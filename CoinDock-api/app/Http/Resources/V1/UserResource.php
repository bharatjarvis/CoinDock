<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Currency\Util\CurrencySymbolUtil;

class UserResource extends JsonResource
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
            'title' => $this->title,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'country' => $this->country,
            'recovery_attempts' => $this->recovery_attempts,
            'type' => $this->type,
            'date_of_birth' => $this->date_of_birth,
            'status' => $this->status,
            'primary_currency' => $this->setting->primary_currency,
            'primary_currency_symbol' => CurrencySymbolUtil::getSymbol($this->setting->primary_currency),
            'secondary_currency' => $this->setting->secondary_currency,
            'secondary_currency_symbol' => CurrencySymbolUtil::getSymbol($this->setting->secondary_currency),

        ];
    }
}
