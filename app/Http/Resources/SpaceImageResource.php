<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpaceImageResource extends JsonResource
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
            'default'   => $this->getFullUrl(),
            'thumbnail' => $this->getFullUrl('space-thumbnail'),
        ];
    }
}
