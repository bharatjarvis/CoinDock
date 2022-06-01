<?php

namespace Database\Factories\V1;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\OauthClient>
 */
class OauthClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name'=>'Laravel Personal Access Client',
            'secret'=>'VqEJt8JcqdsqtvlbDUiUNVTC4Mg3zmkXfNAeYfZt',
            'redirect'=>'http://localhost',
            'personal_access_client'=>1,
            'password_client'=>1,
            'revoked'=>0
        ];
    }
}
