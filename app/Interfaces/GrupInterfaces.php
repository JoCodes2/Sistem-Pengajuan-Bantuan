<?php

namespace App\Interfaces;

use App\Http\Requests\GrupRequest;

interface GrupInterfaces
{
    public function getAllData();
    public function createData(GrupRequest $request);
    public function getDataById($id);
    public function updateDataById(GrupRequest $request, $id);
    public function deleteData($id);
}
