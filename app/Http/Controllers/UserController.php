<?php

namespace App\Http\Controllers;

use App\Events\NotifyManagementEvent;
use App\Models\User;
use App\Repositories\MediaRepository;
use App\Repositories\ReportSellerRepository;
use App\Repositories\UserRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request, $status = null)
    {
        $search = $request->search;
        $perPage = $request->query('per_page') ?? 10;
        $users = UserRepository::getByStatus($status, $search, $perPage);

        $myProfileData = UserRepository::query()->with('profilePhoto')->find(auth()->id());

        return view('admin.users.index', compact('users', 'status', 'search', 'myProfileData'));
    }


    public function updateStatus(Request $request, $id)
    {
        $user = UserRepository::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'User status updated!');
    }


    public function edit($id)
    {
        $user = UserRepository::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        $myProfileData = UserRepository::query()->with('profilePhoto')->find(auth()->id());
        return view('admin.users.edit', compact('user', 'roles', 'myProfileData'));
    }


    public function update(Request $request, $id)
    {
        $user = UserRepository::findOrFail($id);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::updateByRequest($user, $request->file('thumbnail'), 'users');
            $user->profile_photo_id = $media->id;
        }

        $user->update($request->except(['password', 'thumbnail']));
        $user->save();

        // Initial variables
        $receiverIds = $id;
        $senderId = auth()->id();
        $subject = "Account is {$request->status}";
        $body = "Your Account has been {$request->status} By Admin";

        // Start Notification
        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );


        // Assign new role (remove old roles first)
        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        return back()->with('success', 'User Updated successfully!');
    }

    public function showReports($id)
    {
        $user = UserRepository::query()->findOrFail($id);
        $reports = ReportSellerRepository::query()
            ->where('seller_id', $id)
            ->with(['reporter'])
            ->latest()
            ->paginate(15);

        return view('admin.users.show-report', compact('reports', 'user'));
    }

    public function delete($id)
    {
        $user = UserRepository::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $user = UserRepository::query()->withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    // Report Generation
    public function usersReport(Request $request)
    {
        $format = $request->input('format', 'pdf');
        $range = $request->input('range', 'today');
        $users = UserRepository::getUsersByDateRange($range, $request);
        $dateTitle = UserRepository::getDateRangeTitle($range, $request);
        $stats = UserRepository::getReportStats($users);

        if ($format === 'pdf') {
            return $this->downloadPDF($users, $dateTitle, $stats);
        } else {
            return $this->downloadCSV($users, $dateTitle);
        }
    }

    private function downloadPDF($users, $dateTitle, $stats)
    {
        $pdf = Pdf::loadView('admin.reports.users-pdf', [
            'users' => $users,
            'dateTitle' => $dateTitle,
            'stats' => $stats,
            'generatedAt' => now()->format('d M Y, h:i A')
        ]);
        $fileName = 'users-report-' . now()->format('Y-m-d-His') . '.pdf';
        return $pdf->download($fileName);
    }

    private function downloadCSV($users, $dateTitle)
    {
        $fileName = 'users-report-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($users, $dateTitle) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Users Report - ' . $dateTitle]);
            fputcsv($file, []);
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Status', 'Verified', 'Joined Date']);

            // Data rows
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email ?? 'N/A',
                    $user->phone_no ?? 'N/A',
                    $user->status,
                    ($user->email_verified_at || $user->phone_verified_at) ? 'Yes' : 'No',
                    $user->created_at->format('d M Y h:i A')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
