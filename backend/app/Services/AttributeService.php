<?php

namespace App\Services;

use App\Models\Attribute;
use App\DTO\AttributeDTO;
use Exception;

class AttributeService
{
    public function getAllAttributes()
    {
        try {
            return Attribute::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getAttributeById(int $id)
    {
        try {
            return Attribute::findOrFail($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createAttribute(AttributeDTO $attributeDTO)
    {
        try {
            return Attribute::create([
                'name' => $attributeDTO->name,
                'data_type' => $attributeDTO->data_type,
                'unit' => $attributeDTO->unit,
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateAttribute(int $id, AttributeDTO $attributeDTO)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->update([
                'name' => $attributeDTO->name,
                'data_type' => $attributeDTO->data_type,
                'unit' => $attributeDTO->unit,
            ]);
            return $attribute;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteAttribute(int $id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            return ['message' => 'Attribute deleted successfully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

