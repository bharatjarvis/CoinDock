<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RecoveryCodeResource extends JsonResource
{
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {

        return [
            'user_id' => $this->user_id,
            'recovery_codes' => explode(' ', $this->recovery_code),
            'status' => $this->status
            
        ];
    }
}
