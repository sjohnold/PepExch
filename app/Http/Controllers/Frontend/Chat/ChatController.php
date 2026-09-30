<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Repositories\SellingPostRepository;
use App\Repositories\UserRepository;
use App\Events\MessageSent;
use App\Events\SellerConversationEvent;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\ConversationManageResource;
use App\Http\Resources\MessageManageResource;
use App\Models\Media;
use App\Models\MessageThumbnail;
use App\Repositories\ConversationRepository;
use App\Repositories\MediaRepository;
use App\Repositories\MessageRepository;
use App\Repositories\SettingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ChatController extends Controller
{

    public function index(Request $request)
    {
        $authId = auth()->id();
        $sellerId = $request->query('seller_id');
        $postId = $request->query('post_id');

        // If seller_id provided, ensure conversation exists
        if ($sellerId && $sellerId != $authId) {
            $conversation = ConversationRepository::findBySenderAndReceiver($authId, $sellerId);
            if (!$conversation) {
                $conversation = Conversation::create([
                    'sender_id' => $authId,
                    'receiver_id' => $sellerId,
                ]);
            }
        }

        $convs = ConversationRepository::query()->where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->with(['messages' => fn($q) => $q->latest('created_at')->take(1)])
            ->get();


        $convs = $convs->sortByDesc(function ($c) {
            return $c->messages->first()?->created_at;
        });


        $users = $convs->map(function ($conv) use ($authId) {
            $otherId = $conv->sender_id == $authId ? $conv->receiver_id : $conv->sender_id;
            $user    = UserRepository::find($otherId);

            if ($user) {
                $lastMsg = $conv->messages->first();
                $user->lastMessageWithAuth = $lastMsg;
                $user->conversationId      = $conv->id;
                $user->hasUnread = $lastMsg && $lastMsg->receiver_id == $authId && !$lastMsg->is_read;
            }
            return $user;
        })->filter();

        return \Inertia\Inertia::render('Chat', [
            'chatUsers' => $users->values(),
            'initialSellerId' => $sellerId ? (int) $sellerId : null,
            'initialPostId' => $postId ? (int) $postId : null,
        ]);
    }

    public function getUserDetails(Request $request)
    {
        $user = UserRepository::query()->with('lastMessage')->findOrFail($request->id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'is_online' => $user->is_online,
            'profilePhotoPath' => $user->profilePhotoPath,
            'lastMessage' => $user->lastMessage?->content,
        ]);
    }

    public function sendMessage(Request $request)
    {

        try {
            $message = MessageRepository::storeByRequest($request);

            SellerConversationEvent::dispatch($message);

            return response()->json([
                'success'         => true,
                'message'         => $message->contact,
                'media'           => $message->media_path,
                'conversation_id' => $message->conversation_id,
            ]);
        } catch (Exception $e) {
            Log::error('Send Message Error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function store(MessageRequest $request)
    {
        MessageRepository::storeByRequest($request);
        return redirect('chat')->with('success', 'Offer sent successfully!');
    }

    public function fetchMessages(User $user, Request $request)
    {
        $authId = auth()->id();
        $page   = $request->query('page', 1);

        $conversation = ConversationRepository::findBySenderAndReceiver(
            $authId,
            $user->id
        );

        if (!$conversation) {
            return response()->json([
                'messages'  => [],
                'next_page' => false,
            ]);
        }

        $messages = MessageRepository::query()
            ->where('conversation_id', $conversation->id)
            ->with(['sender', 'receiver', 'thumbnails', 'offer', 'sellingPost'])
            ->orderBy('id', 'desc')
            ->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'messages'     => MessageManageResource::collection(collect($messages->items())->reverse()),
            'next_page'    => $messages->hasMorePages(),
            'current_page' => $messages->currentPage(),
        ]);
    }


    public function markAsRead(User $user)
    {
        $authId = auth()->id();

        $conversation = ConversationRepository::findBySenderAndReceiver(
            $authId,
            $user->id
        );

        if ($conversation) {
            $conversation->messages()
                ->where('receiver_id', $authId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }


    public function usersPaginated(Request $request)
    {
        $authId = auth()->id();
        $perPage = 5;

        $convs = ConversationRepository::query()
            ->where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->with(['messages' => fn($q) => $q->latest('created_at')->take(1)])
            ->get();

        $convs = $convs->sortByDesc(fn($c) => $c->messages->first()?->created_at);

        $users = $convs->map(function ($conv) use ($authId) {
            $otherId = $conv->sender_id == $authId ? $conv->receiver_id : $conv->sender_id;
            $user    = UserRepository::find($otherId);

            if ($user) {
                $lastMsg = $conv->messages->first();
                $user->lastMessageWithAuth = $lastMsg;
                $user->conversationId      = $conv->id;
                $user->hasUnread = $lastMsg && $lastMsg->receiver_id == $authId && !$lastMsg->is_read;
            }
            return $user;
        })->filter();

        $page = $request->input('page', 1);
        $slice = $users->forPage($page, $perPage);
        $paginator = new LengthAwarePaginator($slice, $users->count(), $perPage, $page, [
            'path' => $request->url(),
        ]);

        return response()->json([
            'users' => $slice->values(),
            'next_page' => $paginator->nextPageUrl() ? $page + 1 : null,
        ]);
    }
}
