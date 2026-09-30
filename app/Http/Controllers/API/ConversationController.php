<?php

namespace App\Http\Controllers\API;

use App\Events\SellerConversationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakeOfferRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\ConversationManageResource;
use App\Http\Resources\MessageManageResource;
use App\Http\Resources\User\ChatUserResource;
use App\Http\Resources\User\UserResource;
use App\Models\MessageThumbnail;
use App\Models\User;
use App\Repositories\ConversationRepository;
use App\Repositories\MediaRepository;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

#[Group('Conversation API')]
class ConversationController extends Controller
{

    /**
     * Make offer
     *
     */
    #[BodyParameter('receiver_id', required: true, type: 'string', example: '10')]
    #[BodyParameter('selling_post_id', required: true, type: 'string', example: '22')]
    #[BodyParameter('offer_message', required: true, type: 'string', example: 'please give me')]

    public function store(MessageRequest $request)
    {
        $message = MessageRepository::storeByRequest($request);

        return $this->json('Offer sent successfully!', [
            'conversation_id' => $message->conversation_id,
            'message_id'      => $message->id,
            'message'      => $message->contact,
        ], 200);
    }


    /**
     * Fetch Messages
     *
     */
    #[QueryParameter('receiver_id', required: true, type: 'string', example: '10')]

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
            ->with(['chatUser', 'sellingPost', 'thumbnails'])
            ->orderBy('id', 'desc')
            ->paginate(20, ['*'], 'page', $page);

        return $this->json('Fetch Message Successfully!', [
            'messages'     => ConversationManageResource::collection(collect($messages->items())->reverse()),
            'next_page'    => $messages->hasMorePages(),
            'current_page' => $messages->currentPage(),
        ], 200);
    }

    /**
     * Send Messages
     *
     */
    #[BodyParameter('receiver_id', required: true, type: 'string', example: '10')]
    #[BodyParameter('selling_post_id', required: false, type: 'string', example: '22')]
    #[BodyParameter('message', required: false, type: 'string', example: 'please give me')]
    #[BodyParameter('chatFile', required: false, type: 'double', example: 1200)]

    public function sendMessage(SendMessageRequest $request)
    {
        $message = MessageRepository::storeByRequest($request);

        SellerConversationEvent::dispatch($message);

        return $this->json('Send message successfully', [
            'success'         => true,
            'message'         => ConversationManageResource::make($message),
            'conversation_id' => $message->conversation_id,
        ], 200);
    }

    /**
     * Mark As Read
     *
     */
    #[BodyParameter('receiver_id', required: true, type: 'string', example: '10')]

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

        return $this->json('Mark As Read Successfully', [
            'conversation_id' => $conversation,
        ], 200);
    }
    /**
     * Get User Details
     *
     */
    #[QueryParameter('id', required: true, type: 'string', example: '10')]
    public function getUserDetails(Request $request)
    {
        $user = UserRepository::query()->with('lastMessage')->findOrFail($request->id);

        return $this->json('Get User Details Successfully', [
            'user' => UserResource::make($user),
        ]);
    }

    public function chatHead(Request $request)
    {
        $authId = auth()->id();

        $perPage = (int) $request->input('items_per_page', 10);
        $pageNumber = (int) $request->input('page_number', 1);

        // Get conversations with last message
        $conversations = ConversationRepository::query()
            ->where(function ($q) use ($authId) {
                $q->where('sender_id', $authId)
                    ->orWhere('receiver_id', $authId);
            })
            ->with(['messages' => fn($q) => $q->latest()->take(1)])
            ->get()

            //  KEY FIX: group by other user
            ->groupBy(function ($conversation) use ($authId) {
                return $conversation->sender_id == $authId
                    ? $conversation->receiver_id
                    : $conversation->sender_id;
            })

            // take latest conversation per user
            ->map(function ($group) {
                return $group->sortByDesc(
                    fn($c) => $c->messages->first()?->created_at
                )->first();
            })

            ->sortByDesc(fn($c) => $c->messages->first()?->created_at)
            ->values();

        return response()->json([
            'success' => $conversations->isNotEmpty(),
            'message' => $conversations->isNotEmpty() ? 'Users found' : 'No users found',
            'total_items' => $conversations->count(),
            'users' => ChatUserResource::collection($conversations),
        ]);
    }
}
