<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($page)
    {
        $page = json_decode(PageRepository::query()->where('section', $page)->first());
        return view('web.pages.pages', compact('page'));
    }
}
