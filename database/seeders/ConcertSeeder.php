<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Concert;
use Faker\Factory as Faker;

class ConcertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $unsplashImages = [
            'https://images.unsplash.com/photo-1563841930606-67e2bce48b78?q=80&w=1472&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1568215425379-7a994872739d?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1727425812012-1173bb74591b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ];

        for ($i = 0; $i < count($unsplashImages); $i++) {
            $concert = Concert::create([
                'title' => $faker->sentence(3),
                'artist' => $faker->name,
                'date' => $faker->date(),
                'location' => $faker->city,
                'banner' => $unsplashImages[$i],
                'quota' => $faker->numberBetween(50, 500),
            ]);

            // Add ticket types vip and festival to each concert
            $concert->ticketTypes()->createMany([
                [
                    'name' => 'VIP',
                    'price' => 1000000,
                    'quota' => 50,
                    'type' => 'seated',
                ],
                [
                    'name' => 'Festival',
                    'price' => 500000,
                    'quota' => 200,
                    'type' => 'standing',
                ],
            ]);
        }
    }
}
