<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Inertia\Inertia;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $newsCategories = NewsCategory::all();

        return Inertia::render('NewsCategories/Index', [
            "newsCategories" => $newsCategories,
            "emptyMessage" => $newsCategories->isEmpty() ? "Không có danh mục tin tức nào" : null
        ]);
    }
}
