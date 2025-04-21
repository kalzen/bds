<?php

use App\Models\Ward;

class WardService
{
    public function createWard(array $data)
    {
        return Ward::create($data);
    }

    public function getWardById(int $id)
    {
        return Ward::findOrFail($id);
    }

    public function updateWard(int $id, array $data)
    {
        $ward = Ward::findOrFail($id);
        $ward->update($data);

        return $ward;
    }

    public function deleteWard(int $id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();
    }
}
