
<?php
use App\Models\Property;

class PropertyService
{
    public function createProperty(array $data)
    {
        return Property::create($data);
    }

    public function getPropertyById(int $id)
    {
        return Property::findOrFail($id);
    }

    public function updateProperty(int $id, array $data)
    {
        $property = Property::findOrFail($id);
        $property->update($data);

        return $property;
    }

    public function deleteProperty(int $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
    }
}
