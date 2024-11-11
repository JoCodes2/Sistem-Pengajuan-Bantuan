<?php

namespace App\Interfaces;

use App\Http\Requests\SubmissionRequest;

interface SubmissionInterfaces
{
    public function getAllData();
    public function createData(SubmissionRequest $request);
    public function getDataById($id);
    public function updateDataById(SubmissionRequest $request, $id);
    public function deleteData($id);
}
