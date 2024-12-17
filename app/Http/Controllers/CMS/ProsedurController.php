<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProsedurRequest;
use App\Repositories\ProsedurRepositories;
use Illuminate\Http\Request;

class ProsedurController extends Controller
{
    protected $ProsedurRepo;
    public function __construct(ProsedurRepositories $ProsedurRepo)
    {
        $this->ProsedurRepo = $ProsedurRepo;
    }
    public function getAllData()
    {
        return $this->ProsedurRepo->getAllData();
    }
    public function createData(ProsedurRequest $request)
    {
        return $this->ProsedurRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->ProsedurRepo->getDataById($id);
    }
    public function updateDataById(ProsedurRequest $request, $id)
    {
        return $this->ProsedurRepo->updateDataById($request, $id);
    }
    public function deleteData($id)
    {
        return $this->ProsedurRepo->deleteData($id);
    }
}
