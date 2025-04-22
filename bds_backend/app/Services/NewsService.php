<?php

namespace App\Services;

use App\Models\News;

class NewsService
{
    public function create(array $data)
    {
        return News::create($data);
    }

    public function findbyID(int $id)
    {
        return News::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $news = News::findOrFail($id);
        $news->update($data);
        return $news;
    }

    public function delete(int $id)
    {
        $news = News::findOrFail($id);
        return $news->delete();
    }
}
