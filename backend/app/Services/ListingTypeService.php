<?php

namespace App\Services;

use App\Models\ListingType;
use App\DTO\ListingTypeDTO;
use Exception;

class ListingTypeService
{
    public function getAllListingTypes()
    {
        try {
            return ListingType::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getListingTypeById(int $id)
    {
        try {
            return ListingType::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createListingType(ListingTypeDTO $listingTypeDTO)
    {
        try {
            return ListingType::create([
                'name' => $listingTypeDTO->name,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateListingType(int $id, ListingTypeDTO $listingTypeDTO)
    {
        try {
            $listingType = ListingType::findOrFail($id);
            $listingType->update([
                'name' => $listingTypeDTO->name,
            ]);
            return $listingType;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteListingType(int $id)
    {
        try {
            $listingType = ListingType::findOrFail($id);
            $listingType->delete();
            return ['message' => 'ListingType deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
