<?php

namespace Database\Seeders;


use Altwaireb\World\Database\Seeders\BaseWorldSeeder;
use Altwaireb\World\Exceptions\InvalidCodeException;

class WorldSeeder extends BaseWorldSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->serves->ensureIsInsertActivationsHasIsoCodes();
            $this->serves->ensureIsoCodesIsValid();
            $this->createCountries();
        } catch (InvalidCodeException $e) {
            $this->command->error($e->getMessage());
        }
    }
}
