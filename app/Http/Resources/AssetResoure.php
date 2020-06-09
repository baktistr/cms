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
        $type = Asset::$types[$this->type] ?? null;

        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'type'           => $this->when($this->type, $type),
            'price'          => $this->price,
            'formattedPrice' => $this->formatted_price,
            'priceType'      => $this->priceType,
            'category'       => AssetCategoryResource::make($this->category),
            'province'       => ProvinceResource::make($this->province),
            'regency'        => RegencyResource::make($this->regency),
            'district'       => DistrictResource::make($this->district),
            'address'        => $this->address_detail,
            'images'         => AssetImageResource::collection(collect($this->getMedia('image'))),
        ];
    }
}
