<?php

namespace Database\Seeders;

use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach(range(1,25) as $i){
            $user = $users->random();

            TravelRequest::create([
                'user_id' => $user->id,
                'requester_name' => $user->name,
                'destination' => fake()->city(),
                'departure_date' => now()->addDays(rand(1, 15)),
                'return_date' => now()->addDays(rand(16, 30)),
                'status' => fake()->randomElement(['requested', 'approved', 'canceled']),
            ]);

        }
    }
}
