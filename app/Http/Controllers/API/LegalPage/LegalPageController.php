<?php

namespace App\Http\Controllers\API\LegalPage;

use App\Http\Controllers\Controller;
use App\Http\Resources\Page\PageResource;
use App\Repositories\PageRepository;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Illuminate\Http\Request;

#[Group('Pages')]
class LegalPageController extends Controller
{

    /**
     * Get Legal pages
     *
     */

    #[PathParameter('about', required: true, type: 'string', example: 'about')]
    #[PathParameter('contact-us', required: true, type: 'string', example: 'contact-us')]
    #[PathParameter('privacy-policy', required: true, type: 'string', example: 'privacy-policy')]
    #[PathParameter('terms-conditions', required: true, type: 'string', example: 'terms-conditions')]
    public function index($type)
    {
        $page = json_decode(PageRepository::query()->where('section', $type)->first());
        return $this->json('Page Fetched Sucessfully', PageResource::make($page), 200);
    }
}
