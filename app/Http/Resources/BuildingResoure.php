<?php

namespace App\Http\Resources;

use App\Building;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResoure extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'allotment'      => $this->allotment,
            'phone_number'   => $this->phone_number,
            'surface_area'   => $this->surface_area,
            'images'         => BuildingImageResource::collection(collect($this->getMedia('image'))),
            'area'           => AreaResource::make($this->area),
            'manager'        => UserResource::make($this->pic),     
        ];
    }
}
