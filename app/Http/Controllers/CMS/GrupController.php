<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\GrupRequest;
use App\Repositories\GrupRepositories;

class GrupController extends Controller
{
    protected $GrupRepo;
    public function __construct(GrupRepositories $GrupRepo)
    {
        $this->GrupRepo = $GrupRepo;
    }
    public function getAllData()
    {
        return $this->GrupRepo->getAllData();
    }
    public function createData(GrupRequest $request)
    {
        return $this->GrupRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->GrupRepo->getDataById($id);
    }
    public function updateDataById(GrupRequest $request, $id)
    {
        return $this->GrupRepo->updateDataById($request, $id);
    }
    public function deleteData($id)
    {
        return $this->GrupRepo->deleteData($id);
    }
}
