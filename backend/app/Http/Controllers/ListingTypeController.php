<?php

namespace App\Http\Controllers;

use App\Services\ListingTypeService;
use App\DTO\ListingTypeDTO;
use Illuminate\Http\Request;

class ListingTypeController extends Controller
{
    public function __construct(private ListingTypeService $listingTypeService) {}

    public function index()
    {
        return response()->json($this->listingTypeService->getAllListingTypes());
    }

    public function show(int $id)
    {
        return response()->json($this->listingTypeService->getListingTypeById($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $listingTypeDTO = new ListingTypeDTO(
            $request->input('name')
        );
        $listingType = $this->listingTypeService->createListingType($listingTypeDTO);

        return response()->json($listingType, 201);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $listingTypeDTO = new ListingTypeDTO(
            $request->input('name')
        );
        $listingType = $this->listingTypeService->updateListingType($id, $listingTypeDTO);

        return response()->json($listingType);
    }

    public function destroy(int $id)
    {
        $this->listingTypeService->deleteListingType($id);

        return response()->noContent();
    }
}
