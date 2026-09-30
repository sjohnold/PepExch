<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class PageRepository extends Repository
{
    public static function model()
    {
        return Page::class;
    }

    public static function updateAllPage($request, $section)
    {
        $page = Page::where('section', $section)->first();
        $data = [
            [
                "title" => $request->title,
                "description" => $request->description
            ]
        ];

        return self::update($page, [
            'data' => $data
        ]);
    }
}
