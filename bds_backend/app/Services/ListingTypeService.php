<?php

namespace App\Services;

use App\Models\ListingType;

class ListingTypeService
{
    public function create(array $data)
    {
        return ListingType::create($data);
    }

    public function getAll()
    {
        return ListingType::all();
    }

    public function getById($id)
    {
        return ListingType::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $listingType = ListingType::findOrFail($id);
        $listingType->update($data);
        return $listingType;
    }

    public function delete($id)
    {
        $listingType = ListingType::findOrFail($id);
        $listingType->delete();
        return true;
    }
}
