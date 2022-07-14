<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\V1\Coin;

class CoinCardResource extends JsonResource
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
        $coin = Coin::whereIsDefault(1)->first();
        return [
            'coin_name' => $this->coin_id,
            'logo' =>  $this->img_path,
            $coin->coin_id . '_coin'  =>  $this->defaultCoin(),
            'number_of_coins' =>  $this->countCoins(),
            'primary_currency' => $this->getPrimaryCurrency(),
            'secondary_currency' => $this->getSecondaryCurrency(),
        ];
    }
}
