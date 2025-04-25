<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Concert;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $concerts = Concert::all();

        foreach ($users as $user) {
            // Each user will have between 2 to 5 tickets for random concerts
            $numTickets = rand(2, 5);

            for ($i = 0; $i < $numTickets; $i++) {
                $concert = $concerts->random();

                $ticketType = $concert->ticketTypes()->inRandomOrder()->first();

                Ticket::create([
                    'user_id' => $user->id,
                    'ticket_type_id' => $ticketType->id,
                    'concert_id' => $ticketType->concert_id,
                    'unique_code' => strtoupper(Str::random(10)),
                ]);
            }
        }
    }
}
