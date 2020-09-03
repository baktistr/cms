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
            'type'           => $this->type,
            'description'    => $this->description,
            'address'        => $this->address_detail,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
            'numberOfFloors' => $this->number_of_floors,
            'price'          => $this->when($this->type === 'sale', $this->price),
            'formattedPrice' => $this->when($this->type === 'sale', $this->formatted_price),
            'province'       => ProvinceResource::make($this->province),
            'regency'        => RegencyResource::make($this->regency),
            'district'       => DistrictResource::make($this->district),
            'images'         => BuildingImageResource::collection(collect($this->getMedia('image'))),
            'allotment'      => $this->allotment,
            'phone_number'   => $this->phone_number,
            'surface_area'   => $this->surface_area,
            'area'           => AreaResource::make($this->area),
            'manager'        => UserResource::make($this->pic),      
        ];
    }
}
