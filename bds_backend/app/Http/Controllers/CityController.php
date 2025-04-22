<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        return Inertia::render('Cities/Index', [
            "cities" => $cities,
            "emptyMessage" => $cities->isEmpty() ? "Không có thành phố nào" : null
        ]);
    }

}
