<?php

namespace App\Http\Controllers\Api\Space;

use App\BuildingSpace;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingSpaceResource;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchQuery    = $request->get('gedung');

        $searhcSpace    = $request->get('space');

        $searhAllotment = $request->get('allotment');

        $province = $request->get('province');

        $space = BuildingSpace::with(['building', 'building.area.provinsi'])
            ->where('is_available', true)
            ->when(isset($searhcSpace) && !empty($searhcSpace), function ($query) use ($searhcSpace) {
                $query->where('name', 'LIKE', "%{$searhcSpace}%");
            })
            ->when(isset($searchQuery) && !empty($searchQuery), function ($query) use ($searchQuery) {
                $query->whereHas('building', function ($building) use ($searchQuery) {
                    $building->where('name', 'LIKE', "%{$searchQuery}%");
                });
            })
            ->when(isset($searhAllotment) && !empty($searhAllotment), function ($query) use ($searhAllotment) {
                $query->whereHas('building', function ($building) use ($searhAllotment) {
                    $building->where('allotment', 'LIKE', "%{$searhAllotment}%");
                });
            })->when(isset($province) && !empty($province), function ($query) use ($province) {
                $query->whereHas('building.area.provinsi', function ($query) use ($province) {
                    $query->where('name', 'LIKE', "%{$province}%");
                });
            });

        return BuildingSpaceResource::collection($space->paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $space = BuildingSpace::with('building')
            ->where('is_available', true)
            ->find($id);
        if (!$space) {
            return response()->json(['message' => 'space not found'], 404);
        }
        return new BuildingSpaceResource($space);
    }
}
