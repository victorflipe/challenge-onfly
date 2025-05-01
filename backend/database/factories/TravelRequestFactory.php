<?php

namespace Database\Factories;

use App\Models\TravelRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelRequestFactory extends Factory
{
    protected $model = TravelRequest::class;

    public function definition(): array
    {
        return [
            'requester_name' => $this->faker->name,
            'destination' => $this->faker->city,
            'departure_date' => $this->faker->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d'),
            'return_date' => $this->faker->dateTimeBetween('+2 days', '+2 months')->format('Y-m-d'),
            'status' => 'requested', // ou aprovado, cancelado
        ];
    }
}
