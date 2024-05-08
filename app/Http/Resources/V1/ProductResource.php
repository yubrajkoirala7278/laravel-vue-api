<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // ====to get all data of db table====
        // return parent::toArray($request);

        // =====to get only the mentioned data of db table===
        return [
            // 'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            // 'image' => $this->image,
            'image_url'=>$this->image_url,
            'price'=>$this->price,
            'cross_price'=>$this->cross_price,
            'color'=>$this->color,
            'description'=>$this->description
        ];
    }
}
