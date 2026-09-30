<?php

namespace App\Http\Controllers;

use App\Events\AnnouncementCreated;
use App\Http\Requests\AnnouncementRequest;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // show all announcement
    public function index()
    {
        $announcements = NotificationRepository::query()->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    //creating Announcement
    public function create()
    {
        $users = UserRepository::getAll()->where('status', 'Approve');
        return view('admin.announcements.create', compact('users'));
    }


    public function store(AnnouncementRequest $request)
    {
        $data = $request->validated();
        $type = in_array('Other', $data['types']) ? $data['other_type'] : $data['types'][0];

        $message = json_encode([
            'title' => $data['title'],
            'body' => $data['body'],
            'type' => $type,
        ]);

        $announcement = NotificationRepository::create([
            'user_id' => $data['users'][0],
            'user_ids' => json_encode($data['users']),
            'message' => $message,
            'read_status' => json_encode([]),
        ]);

        AnnouncementCreated::dispatch($announcement, $data['users']);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created & mails are being sent.');
    }

    // Perticular announcement show page
    public function show($id)
    {
        $announcement = NotificationRepository::findOrFail($id);

        // Decode message JSON
        $messageData = json_decode($announcement->message, true);
        $announcement->title = $messageData['title'] ?? '';
        $announcement->body  = $messageData['body'] ?? '';
        $announcement->type  = $messageData['type'] ?? '';

        // Get users via UserRepository
        $userIds = json_decode($announcement->user_ids, true) ?? [];
        $users = UserRepository::query()
            ->whereIn('id', $userIds)
            ->get();

        return view('admin.announcements.show', compact('announcement', 'users'));
    }


    // Delete / Destroy Announcement (short version)
    public function destroy($id)
    {
        $announcement = NotificationRepository::findOrFail($id);

        NotificationRepository::delete($announcement->id);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
