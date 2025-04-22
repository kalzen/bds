<?php
namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function create(array $data): Property
    {
        return Property::create($data);
    }

    public function findbyID(int $id): ?Property
    {
        return Property::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $property = Property::find($id);
        return $property ? $property->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $property = Property::find($id);
        return $property ? $property->delete() : false;
    }
}
