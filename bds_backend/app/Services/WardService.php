<?php

namespace App\Services;

use App\Models\Ward;

class WardService
{
    public function create(array $data)
    {
        return Ward::create($data);
    }

    public function findbyID(int $id)
    {
        return Ward::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $ward = Ward::findOrFail($id);
        $ward->update($data);
        return $ward;
    }

    public function delete(int $id)
    {
        $ward = Ward::findOrFail($id);
        return $ward->delete();
    }
}
