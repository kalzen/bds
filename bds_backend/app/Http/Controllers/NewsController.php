<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    // ✅ Index - list news
    public function index()
    {
        $news = News::all();

        return Inertia::render('News/Index', [
            'news' => $news,
            'emptyMessage' => $news->isEmpty() ? 'Không có tin tức nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('News/Create');
    }

    // ✅ Store news
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $this->newsService->create($data);

        return redirect()->route('news.index')->with('success', 'Tin tức đã được tạo.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $news = $this->newsService->getById($id);

        return Inertia::render('News/Edit', [
            'news' => $news,
        ]);
    }

    // ✅ Update news
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $this->newsService->update($id, $data);

        return redirect()->route('news.index')->with('success', 'Cập nhật thành công.');
    }

    // ✅ Delete news
    public function destroy($id)
    {
        $this->newsService->delete($id);

        return redirect()->route('news.index')->with('success', 'Đã xoá tin tức.');
    }
}
