<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Contact;
use App\Models\Offer;
use App\Models\ReportSeller;
use App\Models\SellingPost;
use App\Models\User;
use App\Repositories\NotificationHistoryRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SellingPostRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sellingPosts = SellingPost::query()
            ->with(['user', 'offers'])
            ->withCount('offers')
            ->latest()
            ->take(10)
            ->get();

        $activeUsers = User::query()
            ->where('last_active', '>=', now()->subDays(30))
            ->count();
        $topSellers = ReviewRepository::getTopSellers(5);

        $barterStats = [
            'total_offers' => Offer::count(),
            'pending_offers' => Offer::where('status', 'pending')->count(),
            'accepted_offers' => Offer::where('status', 'accepted')->count(),
            'completed_exchanges' => Offer::where('status', 'completed')->count(),
        ];

        $workbenchStats = [
            'pending_posts' => SellingPost::whereIn('status', [PostStatus::Pending->value, PostStatus::InReview->value])->count(),
            'pending_offers' => $barterStats['pending_offers'],
            'reports' => ReportSeller::count(),
            'disputes' => Offer::where('status', 'disputed')->count(),
            'support_tickets' => Contact::count(),
        ];

        $recentActivity = collect()
            ->merge(SellingPost::query()->latest()->take(5)->get()->map(fn ($post) => [
                'type' => 'Listing',
                'title' => $post->name,
                'date' => $post->created_at,
                'url' => route('posts.edit', $post->id),
            ]))
            ->merge(Offer::query()->with(['sender', 'receiver'])->latest()->take(5)->get()->map(fn ($offer) => [
                'type' => 'Offer',
                'title' => trim(($offer->sender?->name ?? 'User') . ' → ' . ($offer->receiver?->name ?? 'User')),
                'date' => $offer->created_at,
                'url' => route('admin.offers.show', $offer),
            ]))
            ->sortByDesc('date')
            ->take(8)
            ->values();

        $filterPosts = SellingPostRepository::getSellingPostReport();

        return view('pages.home', compact(
            'activeUsers',
            'sellingPosts',
            'topSellers',
            'barterStats',
            'workbenchStats',
            'recentActivity',
            'filterPosts'
        ));
    }


    public function readSingleNotification(Request $request)
    {
        $notification = NotificationHistoryRepository::findOrFail($request->notification_id);
        $notification->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }

    public function readAllNotification()
    {
        NotificationHistoryRepository::query()->where('receiver_id', null)->where('is_read', false)->update(['is_read' => true]);
        session()->flash('success', 'All notifications marked as read.');
        return redirect()->route('admin.dashboard');
    }

    public function loadMoreNotifications(Request $request)
    {
        $perPage = 10;
        $notifications = getNotifications(null, $perPage);
        return response()->json([
            'notifications' => $notifications->items(),
            'has_more' => $notifications->hasMorePages()
        ]);
    }
}
