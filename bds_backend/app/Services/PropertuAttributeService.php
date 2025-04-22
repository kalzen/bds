<?php
namespace App\Services;

use App\Models\PropertyAttribute;

class PropertuAttributeService
{
    public function create(array $data): PropertyAttribute
    {
        return PropertyAttribute::create($data);
    }

    public function findbyID(int $id): ?PropertyAttribute
    {
        return PropertyAttribute::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $attribute = PropertyAttribute::find($id);
        return $attribute ? $attribute->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $attribute = PropertyAttribute::find($id);
        return $attribute ? $attribute->delete() : false;
    }
}
