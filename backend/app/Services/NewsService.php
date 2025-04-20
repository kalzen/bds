<?php

namespace App\Services;

use App\Models\News;
use App\DTO\NewsDTO;
use Exception;

class NewsService
{
    public function getAllNews()
    {
        try {
            return News::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getNewsById(int $id)
    {
        try {
            return News::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createNews(NewsDTO $newsDTO)
    {
        try {
            return News::create([
                'title' => $newsDTO->title,
                'slug' => $newsDTO->slug,
                'description' => $newsDTO->description,
                'content' => $newsDTO->content,
                'author_id' => $newsDTO->author_id,
                'category_id' => $newsDTO->category_id,
                'publish_date' => $newsDTO->publish_date,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateNews(int $id, NewsDTO $newsDTO)
    {
        try {
            $news = News::findOrFail($id);
            $news->update([
                'title' => $newsDTO->title,
                'slug' => $newsDTO->slug,
                'description' => $newsDTO->description,
                'content' => $newsDTO->content,
                'author_id' => $newsDTO->author_id,
                'category_id' => $newsDTO->category_id,
                'publish_date' => $newsDTO->publish_date,
            ]);
            return $news;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteNews(int $id)
    {
        try {
            $news = News::findOrFail($id);
            $news->delete();
            return ['message' => 'News deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
