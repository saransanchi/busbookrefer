<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VolumetricCheck extends JsonResource
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
            'id' => $this->id,
            'Width'=>$this->width,
            'Length'=>$this->length,
            'Height'=>$this->height,
            'Volumetric Value'=>$this->volumetric_value,
        ];
    
}
}
