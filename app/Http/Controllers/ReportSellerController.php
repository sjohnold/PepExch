<?php
namespace App\Http\Controllers;

use App\Events\NotifyManagementEvent;
use App\Http\Requests\SellerReportRequest;
use App\Repositories\ReportSellerRepository;

class ReportSellerController extends Controller
{
    public function store(SellerReportRequest $request)
    {
        $report = ReportSellerRepository::storeReport($request);

        if ($report) {
            $receiverIds = null;
            $senderId    = auth()->id();
            $subject     = "New Report";
            $body        = "A user {$report->reporter->name} reported seller {$report->seller->name}";

            // Start Notification
            NotifyManagementEvent::dispatch(
                $receiverIds,
                $senderId,
                $subject,
                $body
            );

            return response()->json([
                'success' => true,
                'message' => 'Your Report Submitted Successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something Wrong! Try Again',
        ], 500);
    }

    public function delete($id)
    {
        $report = ReportSellerRepository::query()->findOrFail($id);
        if ($report->delete()) {
            return back()->with('success', 'Report Deleted Successfully');
        }
        return back()->with('error', 'Failed to Delete Report');
    }
}
