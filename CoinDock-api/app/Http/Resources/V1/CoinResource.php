<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CoinResource extends JsonResource
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
            'coin_id' => $this->coin_id,
            'name' => $this->name,
            'status' => $this->status,
            'is_crypto' => $this->is_crypto,
            'image_path' => $this->img_path

        ];
    }
}
