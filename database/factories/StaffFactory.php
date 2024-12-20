<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'role' => $this->faker->randomElement(['admin', 'moderator', 'manager']),
            'settings_access' => json_encode([
                'can_edit' => $this->faker->boolean,
                'can_delete' => $this->faker->boolean,
                'can_view' => $this->faker->boolean,
            ])
        ];
    }

    /**
     * Define a state for admin role.
     */
    public function admin()
    {
        return $this->state([
            'role' => 'admin',
            'settings_access' => json_encode([
                'can_edit' => true,
                'can_delete' => true,
                'can_view' => true,
            ]),
        ]);
    }
}
