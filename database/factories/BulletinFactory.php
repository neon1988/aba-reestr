<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bulletin>
 */
class BulletinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->paragraph(20),
            'status' => StatusEnum::Accepted,
            'status_changed_at' => Carbon::now(),
            'status_changed_user_id' => User::factory(),
            'create_user_id' => User::factory()
        ];
    }
}
