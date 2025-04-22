<?php

namespace App\Services;

use App\Models\District;

class DistrictService
{
    public function create(array $data)
    {
        return District::create($data);
    }

    public function getAll()
    {
        return District::all();
    }

    public function getById($id)
    {
        return District::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $district = District::findOrFail($id);
        $district->update($data);
        return $district;
    }

    public function delete($id)
    {
        $district = District::findOrFail($id);
        $district->delete();
        return true;
    }
}
