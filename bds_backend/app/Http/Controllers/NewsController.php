<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Services\NewService;

class NewsController extends Controller
{
    protected $newService;

    public function __construct(NewService $newService)
    {
        $this->newService = $newService;
    }

    public function index()
    {
        return response()->json(News::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->newService->createNews($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->newService->getNewsById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->newService->updateNews($id, $data));
    }

    public function destroy($id)
    {
        $this->newService->deleteNews($id);
        return response()->json(null, 204);
    }
}
