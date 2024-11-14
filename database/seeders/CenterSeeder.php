<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Center;
use App\Models\User;
use Illuminate\Database\Seeder;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        if (!Center::where('inn', '7701234567')->exists()) {
            Center::factory()->create([
                'name' => 'Центр развития детей "Радуга"',
                'legal_name' => 'ООО "Радуга развития"',
                'inn' => '7701234567',
                'kpp' => '770101001',
                'country' => 'Россия',
                'region' => 'Москва',
                'city' => 'Москва',
                'phone' => '+7 (495) 123-45-67',
                'status' => StatusEnum::Accepted,
                'create_user_id' => $user
            ]);
        }

        Center::factory()->count(20)->create();
    }
}
