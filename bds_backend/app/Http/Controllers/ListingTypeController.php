<?php

namespace App\Http\Controllers;

use App\Models\ListingType;
use Illuminate\Http\Request;
use App\Services\ListingTypeService;

class ListingTypeController extends Controller
{
    protected $listingTypeService;

    public function __construct(ListingTypeService $listingTypeService)
    {
        $this->listingTypeService = $listingTypeService;
    }

    public function index()
    {
        return response()->json(ListingType::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $listingType = $this->listingTypeService->createListingType($data);
        return response()->json($listingType, 201);
    }

    public function show($id)
    {
        $listingType = $this->listingTypeService->getListingTypeById($id);
        return response()->json($listingType);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $listingType = $this->listingTypeService->updateListingType($id, $data);
        return response()->json($listingType);
    }

    public function destroy($id)
    {
        $this->listingTypeService->deleteListingType($id);
        return response()->json(null, 204);
    }
}

