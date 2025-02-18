<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => url('/').'/'.$this->image,
            // 'ratings' => number_format($this->ratings->avg('service_rating'),1) ,
            'price'=>$this->price,
            'created_at' => $this->created_at,
        ];
    }
}
