<?php

namespace App\Interfaces;

use App\Http\Requests\ProsedurRequest;

interface ProsedurInterfaces
{
    public function getAllData();
    public function getDataById($id);
    public function updateDataById(ProsedurRequest $request, $id);
    public function deleteData($id);
}
