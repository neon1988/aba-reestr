<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CenterSeeder::class);
        $this->call(SpecialistSeeder::class);

        Artisan::call('scout:flush', [
            'model' => "App\Models\Center",
        ]);

        Artisan::call('scout:import', [
            'model' => "App\Models\Center",
        ]);

        Artisan::call('scout:flush', [
            'model' => "App\Models\Specialist",
        ]);

        Artisan::call('scout:import', [
            'model' => "App\Models\Specialist", // Указываем модель, как в консоли
        ]);


        if (!User::where('email', 'test@example.com')->exists())
        {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('your_password'),
            ]);
        }

        $this->call(WorldSeeder::class);
    }
}
