<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProvincesController extends Controller
{
    /**
     * Display a listing of the provinces.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Cache::remember('api:data:provinces', now()->addYear(), function () {
            return Province::all();
        });

        return ProvinceResource::collection($provinces);
    }
}
