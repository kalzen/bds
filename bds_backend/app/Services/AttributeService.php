<?php

namespace App\Services;

use App\Models\Attribute;
use App\DTO\AttributeDTO;

class AttributeService
{

    public function getAttributeById(int $id)
    {
        return Attribute::findOrFail($id);
    }

    public function createAttribute(array $data)
    {
        return Attribute::create($data);
    }

    public function updateAttribute(int $id, array $data)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($data);

        return $attribute;
    }


    public function deleteAttribute(int $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
    }
}
