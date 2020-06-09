<?php

namespace App\Http\Controllers\Api\Asset;

use App\Asset;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResoure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\AssetResoure
     */
    public function index(Request $request)
    {
        $type = $request->get('type');
        $category = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

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
            });

        return AssetResoure::collection($assets->paginate($request->get('per_page', 10)));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    /**
     * filter the specified resource .
     *
     * @return App\Http\Resources\AssetResoure
     * @param Illuminate\Http\Request
     */
    public function getByCategory(Request $request)
    {
        if (empty($request->get('category'))) {
            return
                AssetResoure::collection(Asset::with(['district', 'province', 'regency', 'category'])
                    ->get());
        } else {
            return AssetResoure::collection(Asset::with(['district', 'province', 'regency', 'category'])
                ->whereHas('category', function ($query) use ($request) {
                    $query->where('name', $request->get('category'));
                })
                ->get());
        }
    }

    /**
     * search the specified resource .
     *
     * @return App\Http\Resources\AssetResoure
     * @param Illuminate\Http\Request
     */
    public function search(Request $request)
    {
        if (!isset($request)) {
            return
                AssetResoure::collection(Asset::with(['district', 'province', 'regency', 'category'])
                    ->get());
        } else {
            return
                AssetResoure::collection(Asset::with(['district', 'province', 'regency', 'category'])
                    ->when(request()->q, function ($asset) {
                        $asset = $asset->where('name', 'like', "%" . request()->q . "%");
                    })
                    ->paginate());
        }
    }
}
