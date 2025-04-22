<?php

namespace App\Http\Controllers;

use App\Models\City;
use Inertia\Inertia;

class WelcomeController
{
    public function index()
    {
        $cities = City::all();

        return Inertia::render('Index', [
            "cities" => $cities,
            "emptyMessage" => $cities->isEmpty() ? "Không có thành phố nào" : null
        ]);
    }

}
