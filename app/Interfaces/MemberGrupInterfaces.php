<?php

namespace App\Interfaces;

use App\Http\Requests\MemberGrupRequest;

interface MemberGrupInterfaces
{
    public function getAllData();
    public function getDataById($id);
    public function updateDataById(MemberGrupRequest $request, $id);
    public function deleteData($id);
}
