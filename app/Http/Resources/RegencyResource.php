<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegencyResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'province'  => ProvinceResource::make($this->whenLoaded('province')),
            'districts' => DistrictResource::collection($this->whenLoaded('districts')),
        ];
    }
}
