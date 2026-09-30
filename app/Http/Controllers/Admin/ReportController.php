<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ReportSellerRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = ReportSellerRepository::query()
            ->with(['reporter', 'seller'])
            ->latest()
            ->paginate(15);

        return view('admin.reports.all_reports', compact('reports'));
    }

    public function delete($id)
    {
        $report = ReportSellerRepository::query()->findOrFail($id);
        if ($report->delete()) {
            return back()->with('success', 'Report deleted successfully.');
        }
        return back()->with('error', 'Failed to delete report.');
    }
}
