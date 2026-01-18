<?php

namespace Database\Factories;

use App\Models\EventParticipant;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventParticipantFactory extends Factory
{
    protected $model = EventParticipant::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'event_id' => Event::inRandomOrder()->value('id'),
            'status' => $this->faker->randomElement([
                'not_registered',
                'on_progress',
                'registered_success'
            ]),
            'joined_at' => now(),
        ];
    }
}