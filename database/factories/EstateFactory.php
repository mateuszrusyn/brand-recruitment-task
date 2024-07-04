<?php

namespace Database\Factories;

use App\Models\Estate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstateFactory extends Factory
{
    protected $model = Estate::class;

    public function definition(): array
    {
        return [
            'supervisor_user_id' => User::factory(),
            'street' => $this->faker->streetAddress,
            'building_number' => $this->faker->buildingNumber,
            'city' => $this->faker->city,
            'zip' => $this->faker->postcode,
        ];
    }
}
