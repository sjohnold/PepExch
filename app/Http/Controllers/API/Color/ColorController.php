<?php

namespace App\Http\Controllers\API\Color;

use App\Http\Controllers\Controller;
use App\Http\Resources\Color\ColorResource;
use App\Repositories\ColorRepository;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = ColorRepository::query()->get();

        return $this->json('Colors fetched successfully', [
            'colors' => ColorResource::collection($colors),
        ]);
    }
}
