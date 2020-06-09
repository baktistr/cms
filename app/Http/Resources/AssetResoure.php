<?php

namespace App\Http\Resources;

use App\Asset;
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
            'id'             => $this->id,
            'name'           => $this->name,
            'type'           => $this->type,
            'description'    => $this->description,
            'address'        => $this->address_detail,
            'numberOfFloors' => $this->number_of_floors,
            'price'          => $this->when($this->type === 'sale', $this->price),
            'formattedPrice' => $this->when($this->type === 'sale', $this->formatted_price),
            'prices'         => $this->when($this->type === 'rent', AssetPriceResource::collection($this->prices)),
            'category'       => AssetCategoryResource::make($this->category),
            'province'       => ProvinceResource::make($this->province),
            'regency'        => RegencyResource::make($this->regency),
            'district'       => DistrictResource::make($this->district),
            'images'         => AssetImageResource::collection(collect($this->getMedia('image'))),
        ];
    }
}
