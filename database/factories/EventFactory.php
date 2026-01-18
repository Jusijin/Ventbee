<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $totalQuota = $this->faker->numberBetween(20, 200);
        $quotaTaken = $this->faker->numberBetween(0, $totalQuota);

        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'event_name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(4),
            'location' => $this->faker->city,
            'date' => $this->faker->dateTimeBetween('+5 days', '+6 months'),
            'total_quota' => $totalQuota,
            'quota_taken' => $quotaTaken,
            'registration_open' => now()->subDays(5),
            'registration_close' => now()->addDays(10),
            'status' => $this->faker->randomElement([
                'open', 'closed', 'on_progress', 'finished'
            ]),
            'role' => 'user',
            'created_by' => User::inRandomOrder()->value('id'),
        ];
    }
}
