<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        if (!User::where('email', 'test@example.com')->exists())
        {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('your_password'),
            ]);
        }




        #$this->call(WorldTableSeeder::class);
    }
}
