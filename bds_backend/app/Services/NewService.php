<?php

namespace App\Services;

use App\Models\News;

class NewService
{
    public function getNewsById(int $id)
    {
        return News::findOrFail($id);
    }

    public function createNews(array $data)
    {
        return News::create($data);
    }

    public function updateNews(int $id, array $data)
    {
        $news = News::findOrFail($id);
        $news->update($data);

        return $news;
    }

    public function deleteNews(int $id)
    {
        $news = News::findOrFail($id);
        $news->delete();
    }
}
