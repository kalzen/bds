<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use App\DTO\NewsDTO;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(private NewsService $newsService) {}

    public function index()
    {
        return response()->json($this->newsService->getAllNews());
    }

    public function show(int $id)
    {
        return response()->json($this->newsService->getNewsById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'author_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:news_categories,id',
            'publish_date' => 'required|date',
        ]);

        $newsDTO = new NewDTO(
            $request->input('title'),
            $request->input('slug'),
            $request->input('content'),
            $request->input('author_id'),
            $request->input('category_id'),
            $request->input('publish_date'),
            $request->input('description')
        );

        $news = $this->newsService->createNews($newsDTO);

        return response()->json($news, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug,' . $id,
            'description' => 'nullable|string',
            'content' => 'required|string',
            'author_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:news_categories,id',
            'publish_date' => 'required|date',
        ]);

        $newsDTO = new NewDTO(
            $request->input('title'),
            $request->input('slug'),
            $request->input('content'),
            $request->input('author_id'),
            $request->input('category_id'),
            $request->input('publish_date'),
            $request->input('description')
        );

        $news = $this->newsService->updateNews($id, $newsDTO);

        return response()->json($news);
    }

    public function destroy(int $id)
    {
        $this->newsService->deleteNews($id);

        return response()->noContent();
    }
}
