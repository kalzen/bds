<?php

namespace App\Services;

use App\Models\ListingType;

class ListingTypeService
{
    public function getListingTypeById(int $id)
    {
        return ListingType::findOrFail($id);
    }

    public function createListingType(array $data)
    {
        return ListingType::create($data);
    }

    public function updateListingType(int $id, array $data)
    {
        $listingType = ListingType::findOrFail($id);
        $listingType->update($data);

        return $listingType;
    }

    public function deleteListingType(int $id)
    {
        $listingType = ListingType::findOrFail($id);
        $listingType->delete();
    }
}
