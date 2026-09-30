<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = TestimonialRepository::getAllOrSearch();
        return view("admin.testimonials.index", compact("testimonials"));
    }

    public function create()
    {
        return view("admin.testimonials.create");
    }


    public function store(TestimonialRequest $request)
    {

        TestimonialRepository::store($request);
        return redirect()->route('testimonials.index')->with('success', 'Testimonial created successfully.');
    }


    public function show($id)
    {
        $testimonial = TestimonialRepository::findOrFail($id);
        return view('admin.testimonials.show', compact('testimonial'));
    }
    public function edit($id)
    {
        $testimonial = TestimonialRepository::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }




    public function update(Request $request, $id)
    {
        // Fetch the testimonial model
        $testimonial = TestimonialRepository::findOrFail($id);
        // Pass the model instance to the repository
        TestimonialRepository::updateTestimonial($testimonial, $request);
        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully');
    }



    public function destroy($id)
    {
        $testimonial = TestimonialRepository::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial deleted successfully');
    }
}
