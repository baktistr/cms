<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'address_detail' => $this->address_detail,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
            'allotment'      => $this->allotment,
            'postal_code'    => $this->postal_code,
            'province'       => ProvinceResource::make($this->provinsi),
            'kabupaten'      => RegencyResource::make($this->kabupaten),
        ];
    }
}
