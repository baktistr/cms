<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\StaticPage;

class StaticPagesController extends Controller
{
    /**
     * Show Static pages
     *
     * @param $slug
     *
     * @return \App\Http\Resources\StaticPageResource|\Illuminate\Http\JsonResponse
     *
     */
    public function show($slug)
    {
        $staticPage = StaticPage::query()
            ->where('slug', $slug)
            ->first();

        if (!$staticPage) {
            return response()->json(['message' => "Static page not found with slug:{$slug}"], 404);
        }

        return StaticPageResource::make($staticPage);
    }
}
