<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Center;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        Specialist::factory()->create([
            'lastname' => 'Иванов',
            'firstname' => 'Иван',
            'middlename' => 'Иванович',
            'country' => 'Россия',
            'region' => 'Московская область',
            'city' => 'Москва',
            'education' => 'Высшее педагогическое образование',
            'phone' => '+7 (999) 123-45-67',
            'status' => StatusEnum::Accepted,
            'create_user_id' => $user
        ]);

        Specialist::factory()->count(20)->create();
    }
}
