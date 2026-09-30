<?php
namespace App\Http\Controllers;

use App\Http\Requests\BoostPlanRequest;
use App\Models\BoostPlan;
use App\Repositories\BoostPlanRepository;
use App\Repositories\BoostPostRepository;
use App\Repositories\MediaRepository;
use App\Repositories\SettingRepository;

class BoostPlanController extends Controller
{
    // All Plans
    public function index()
    {
        $plans = BoostPlanRepository::query()->paginate(10);

        return view('admin.boosts.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.boosts.plans.create');
    }

    //  Store new plan
    public function store(BoostPlanRequest $request)
    {

        $businessSettings = SettingRepository::getAllBusinessSettings();
        $currencySetting  = $businessSettings->where('type', 'Currency')->first();

        $data = $request->except('_token');
        $data['sustain_days'] = $data['sustain_days'] ?? 1;

        // if ($currencySetting->data->currency !== 'USD' && $currencySetting->data->currency !== 'EUR') {
        //     return redirect()->back()->withInput()->with('error', 'Minimum payable amount is 60. (Non-USD/EUR currency)');
        // }

        if (isset($data['plan_items'])) {
            $data['plan_items'] = json_encode($data['plan_items']);
        }
        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $data['thumbnail_id'] = $media->id;
        }

        BoostPlanRepository::create($data);

        return redirect()->route('plans.index')->with('success', 'Boost Plan created successfully.');
    }

    // Show single plan
    public function show(BoostPlan $plan)
    {
        // Decode plan_items JSON to array
        $planItems = json_decode($plan->plan_items, true);

        return view('admin.boosts.plans.show', compact('plan', 'planItems'));
    }

    // Show edit form
    public function edit(BoostPlan $plan)
    {
        $planItems  = json_decode($plan->plan_items, true);
        $thumbnails = MediaRepository::getAll();
        return view('admin.boosts.plans.edit', compact('plan', 'planItems', 'thumbnails'));
    }

    // Update plan
    public function update(BoostPlanRequest $request, $id)
    {
        $plan = BoostPlanRepository::find($id);
        $data = $request->except('_token', '_method');

        if (isset($data['plan_items'])) {
            $data['plan_items'] = json_encode($data['plan_items']);
        }
        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $data['thumbnail_id'] = $media->id;
        }

        $plan->update($data);

        return redirect()->route('plans.index')->with('success', 'Boost Plan updated successfully.');
    }

    // Sold / Expired Plans
    public function sold()
    {
        // Fetch sold plans with plan details
        $soldPlans = BoostPostRepository::getAll();

        return view('admin.boosts.plans.sold', compact('soldPlans'));
    }

    public function destroy(BoostPlan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Boost Plan deleted successfully.');
    }

    // Trash Plans
    public function trash()
    {
        $plans = BoostPlanRepository::query()->onlyTrashed()->get(); // corrected method
        return view('admin.boosts.plans.trash', compact('plans'));
    }
}
