<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResoure extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'category'          => $this->category->name,
            'price'             => $this->price,
            'price_type'        => $this->price_type,
            'address_detail'    => $this->address_detail,
            'unit_area'         => $this->unit_area,
            'value'             => $this->value,
            'number_of_floors'  => $this->number_of_floors,
            'province'          => $this->province->name,
            'regency'           => $this->regency->name,
            'district'          => $this->district->name,
            'is_available'      => $this->is_available,
        ];
    }

}
