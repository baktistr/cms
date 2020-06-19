<?php

namespace App\Http\Controllers\Api\StaticPages;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\StaticPages;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageController extends Controller
{   
    /**
     * return Json Resouce Static Pages 
     * 
     * @return Illuminate\Http\Resources\Json\JsonResource;
     */
    public function index(): JsonResource
    {
        $staticpage = StaticPages::all();

        return StaticPageResource::collection($staticpage);
    }
}
