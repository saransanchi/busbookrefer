<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            "category"=>[
            'id'=>$this->category_id,
            'name'=>$this->category()->first()->category_name,
            ],
            'id' => $this->id,
            'name' => $this->product_name,
            'price' => $this->price

        ];
    }
}
