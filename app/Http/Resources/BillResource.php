<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->amount,
            'paid' => $this->paid,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'subcategory' => SubCategoryResource::make($this->whenLoaded('subCategory')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
