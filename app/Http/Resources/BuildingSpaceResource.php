<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingSpaceResource extends JsonResource
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
            'id'            => $this->id,
            'is_available'  => $this->is_available,
            'name'          => $this->name,
            'desc'          => $this->description,
            'building'      => AssetResoure::make($this->building),
        ];
    }
}
