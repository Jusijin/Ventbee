<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventParticipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventParticipantSeeder extends Seeder
{
    public function run(): void
    {
        EventParticipant::factory()->count(100)->create();
    }
}
