<?php

namespace Database\Factories\V1;

use App\Enums\V1\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->title(),
            'first_name' => $this->faker->name(),
            'last_name'=> $this->faker->name(),
            'type'=> UserType::User,
            'date_of_birth'=>$this->faker->date('Y-m-d'),
            'country'=> $this->faker->country(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'coinDock@123', // password
            'status' => $this->faker->numberBetween(0,1)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}