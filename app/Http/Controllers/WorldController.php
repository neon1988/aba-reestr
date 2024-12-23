<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;

class WorldController extends Controller
{
    public function countries()
    {
        $countries = Country::all();

        return CountryResource::collection($countries);
    }
}
