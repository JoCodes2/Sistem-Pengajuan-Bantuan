<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionRequest;
use App\Repositories\SubmissionsRepositories;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    protected $subRepo;
    public function __construct(SubmissionsRepositories $subRepo)
    {
        $this->subRepo = $subRepo;
    }
    public function getAllData()
    {
        return $this->subRepo->getAllData();
    }
    public function getDataById($id)
    {
        return $this->subRepo->getDataById($id);
    }
    public function createData(SubmissionRequest $request)
    {
        return $this->subRepo->createData($request);
    }
    public function updateDataById(SubmissionRequest $request, $id)
    {
        return $this->subRepo->updateDataById($request, $id);
    }
    public function deleteData($id)
    {
        return $this->subRepo->deleteData($id);
    }
}
