<?php

namespace App\Http\Controllers;

use App\Models\news;
use App\Models\NewsCategory;
use App\Services\newsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class newsController extends Controller
{
    protected newsService $newsService;

    public function __construct(newsService $newsService)
    {
        $this->newsService = $newsService;
    }

    // ✅ Index - list news
    public function index()
    {
        $news = news::with([
            'category:id,name',
            'user:id,full_name',
            'media',
        ])->get();

        return Inertia::render('news/Index', [
            'news' => $news,
            'emptyMessage' => $news->isEmpty() ? 'Không có tin tức nào.' : null,
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        return Inertia::render('news/Form', [
            'categories' => NewsCategory::all(['id', 'name']),
            'auth' => ['user' => auth()->user()],
        ]);
    }

    // ✅ Store news
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'content' => 'required|string|max:65535',
            'category_id' => 'required|integer|exists:news_categories,id',
            'publish_date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id(); // ✅ Assign manually

        $news = News::create($validated); // ✅ Correct method

        if ($request->hasFile('image')) {
            $news->addMediaFromRequest('image')->toMediaCollection('news'); // ✅ Collection name must match
        }

        return redirect()->route('news.index')->with('success', 'Tin tức đã được tạo.');
    }


    // ✅ Show edit form
    public function edit($id)
    {
        $news = News::findOrFail($id);
        logger('INCOMING REQUEST', $news->toArray());
        return Inertia::render('news/Form', [
            'news' => $news,
            'categories' => NewsCategory::all(['id', 'name']),
            'auth' => ['user' => auth()->user()],
        ]);

    }

    // ✅ Update news
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'content' => 'required|string|max:65535',
            'category_id' => 'required|integer|exists:news_categories,id',
            'publish_date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        // ✅ Lấy bản ghi theo ID
        $news = News::findOrFail($id);

        // ✅ Gọi update() trên instance
        $news->update($data);

        // ✅ Cập nhật media nếu có ảnh mới
        if ($request->hasFile('image')) {
            $news->clearMediaCollection('news');
            $news->addMediaFromRequest('image')->toMediaCollection('news');
        }

        return redirect()->route('news.index')->with('success', 'Cập nhật thành công.');
    }


    // ✅ Delete news
    public function destroy($id)
    {
        $this->newsService->delete($id);

        return redirect()->route('news.index')->with('success', 'Đã xoá tin tức.');
    }
}
