<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingSpacePriceResource extends JsonResource
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
            'asset'          => BuildingResoure::make($this->whenLoaded('asset')),
            'price'          => $this->price,
            'formattedPrice' => $this->formatted_price,
            'type'           => $this->type,
        ];
    }
}
