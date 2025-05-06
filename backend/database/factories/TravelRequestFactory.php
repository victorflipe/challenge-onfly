<?php

namespace Database\Factories;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelRequestFactory extends Factory
{
    protected $model = TravelRequest::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        
        return [
            'user_id' => $user->id,
            'requester_name' => $user->name,
            'destination' => $this->faker->city,
            'departure_date' => $this->faker->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d'),
            'return_date' => $this->faker->dateTimeBetween('+2 days', '+2 months')->format('Y-m-d'),
            'status' => 'requested', // ou aprovado, cancelado
        ];
    }
}
