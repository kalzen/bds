<?php

namespace App\Services;

use App\Models\Attribute;

class AttributeService
{
    public function create(array $data)
    {
        return Attribute::create($data);
    }

    public function getAll()
    {
        return Attribute::all();
    }

    public function getById($id)
    {
        return Attribute::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }

    public function delete($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return true;
    }
}
