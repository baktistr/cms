<?php

namespace App\Http\Controllers\Api\Data;

use App\AssetCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetCategoryResource;
use Illuminate\Support\Facades\Cache;

class AssetCategoriesController extends Controller
{
    /**
     * Display a listing of the asset categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Cache::remember('api:data:asset-categories', now()->addYear(), function () {
            return AssetCategory::all();
        });

        return AssetCategoryResource::collection($categories);
    }
}
