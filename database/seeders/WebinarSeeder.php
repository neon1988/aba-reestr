<?php

namespace Database\Seeders;

use App\Models\Webinar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebinarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Webinar::factory()->count(3)->create();

        Webinar::factory()->ended()->count(10)->create();
    }
}
