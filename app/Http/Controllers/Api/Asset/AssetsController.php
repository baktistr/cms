<?php

namespace App\Http\Controllers\Api\Asset;

use App\Asset;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResoure;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $type = $request->get('type');
        $category = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $province = $request->get('province');
        $searchQuery = $request->get('search_query');

        $assets = Asset::with(['district', 'regency', 'province', 'category'])
            ->available()
            ->when(isset($type) && !empty($type), function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when(isset($category) && !empty($category), function ($query) use ($category) {
                $query->where('asset_category_id', $category);
            })
            ->when(isset($minPrice) && !empty($minPrice), function ($query) use ($minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when(isset($maxPrice) && !empty($maxPrice), function ($query) use ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })->when(isset($province) && !empty($province), function ($query) use ($province) {
                $query->where('province_id', $province);
            })
            ->when(isset($searchQuery) && !empty($searchQuery), function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%");
            });

        return AssetResoure::collection($assets->paginate($request->get('per_page', 10)));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \App\Http\Resources\AssetResoure|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $asset = Asset::with(['district', 'regency', 'province', 'category'])
            ->available()
            ->find($id);

        if (!$asset) {
            return response()->json(['message' => "Asset not found with id:{$id}"], 404);
        }

        return new AssetResoure($asset);
    }
}
