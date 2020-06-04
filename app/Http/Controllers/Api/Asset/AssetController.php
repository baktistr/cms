<?php

namespace App\Http\Controllers\Api\Asset;

use App\Asset;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResoure;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\AssetResoure
     */
    public function index()
    {
        return
            AssetResoure::collection(Asset::with(['district', 'province', 'regency', 'category'])
                ->paginate(5));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
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
