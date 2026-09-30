<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Testimonial;

class TestimonialRepository extends Repository
{
    public static function model()
    {
        return Testimonial::class;
    }

    public static function getAllOrSearch($perPage = 10)
    {
        $searchKey = request('search');
        $query     = self::query();

        if ($searchKey) {
            $query->where('name', 'like', "%{$searchKey}%");
        }

        return $query->latest('id')->paginate($perPage);
    }

    public static function store($request)
    {
        return self::create([
            'name'          => $request->name,
            'designation'   => $request->designation,
            'rating'        => $request->rating,
            'description'   => $request->description,
            'thumbnailPath' => $request->file('thumbnail'),
            'status'        => $request->status,
        ]);
    }

    public static function updateTestimonial($testimonial, $request)
    {
        $data = [
            'name'        => $request->name ?? $testimonial->name,
            'designation' => $request->designation ?? $testimonial->designation,
            'rating'      => $request->rating ?? $testimonial->rating,
            'description' => $request->description ?? $testimonial->description,
            'status'      => $request->status ?? $testimonial->status,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnailPath'] = $request->file('thumbnail');
        }

        return $testimonial->update($data);
    }

    public static function getLatestTestimonials($limit = 6)
    {
        return self::query()
            ->with('thumbnile')
            ->latest()
            ->take($limit)
            ->get();
    }
}
