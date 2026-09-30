<?php

namespace App\Http\Controllers;

use App\Enums\Pages;
use App\Http\Requests\LegalPageRequest;
use App\Repositories\PageRepository;
use Symfony\Component\HttpFoundation\Request;

class LegalPageController extends Controller
{


    public function show($type)
    {
        $page = json_decode(PageRepository::query()->where('section', $type)->first());
        return view('admin.legalPages.pages', compact('page'));
    }


    public function updatePage(Request $request, $section)
    {

        $result = PageRepository::updateAllPage($request, $section);
        if ($result) {
            return back()->with('success', 'Updated Successfully');
        }
        return back()->with('error', 'Updated Successfully');
    }
}
