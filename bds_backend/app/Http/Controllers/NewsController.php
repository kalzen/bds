<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();

        return Inertia::render('News/Index', [
            "news" => $news,
            "emptyMessage" => $news->isEmpty() ? "Không có tin tức nào" : null
        ]);
    }
}
