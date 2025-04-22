<?php

namespace App\Http\Controllers;

use App\Models\District;
use Inertia\Inertia;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();

        return Inertia::render('Districts/Index', [
            "districts" => $districts,
            "emptyMessage" => $districts->isEmpty() ? "Không có quận nào" : null
        ]);
    }
}
