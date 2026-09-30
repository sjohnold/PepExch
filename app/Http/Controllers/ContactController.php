<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = ContactRepository::query()->latest()->paginate(10);
        return view('admin.contact.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = ContactRepository::findOrFail($id);
        return view('admin.contact.show', compact('contact'));
    }

    public function destroy($id)
    {
        ContactRepository::delete($id);
        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully.');
    }


    public function store(ContactRequest $request)
    {
        ContactRepository::create($request->validated());
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
