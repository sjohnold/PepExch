<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = ServiceRepository::getAllOrSearch();

        return view("admin.services.index", compact("services"));
    }

    public function create()
    {
        return view("admin.services.create");
    }

    public function store(ServiceRequest $request)
    {
        ServiceRepository::storeData($request);
        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    public function show($id)
    {
        $service = ServiceRepository::findOrFail($id);
        return view("admin.services.show", compact("service"));
    }
    public function edit($id)
    {
        $service = ServiceRepository::findOrFail($id);
        return view("admin.services.edit", compact("service"));
    }

    public function update(ServiceRequest $request, $id)
    {
        $service = ServiceRepository::updateData($request, $id);
        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found!');
        }
        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }


    public function destroy($id)
    {
        $service = ServiceRepository::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }

public function updateStatus(Request $request)
{
    $request->validate([
        'service_id' => 'required',
        'key' => 'required',
        'status' => 'required',
    ]);

    $service = Service::findOrFail($request->service_id);

    $items = $service->services;

    if (!isset($items[$request->key])) {
        return back()->with('error', 'Invalid service key');
    }

    // Update status
    $items[$request->key]['status'] = $request->status;

    // Save
    $service->services = $items;
    $service->save();

    return back()->with('success', 'Status Updated Successfully!');
}

}
