<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberGrupRequest;
use App\Models\MemberGrup;
use App\Repositories\MemberGrupRepositories;
use Illuminate\Http\Request;

class MemberGrupController extends Controller
{
    protected $MemberGrupRepo;
    public function __construct(MemberGrupRepositories $MemberGrupRepo)
    {
        $this->MemberGrupRepo = $MemberGrupRepo;
    }
    public function getAllData()
    {
        return $this->MemberGrupRepo->getAllData();
    }
    public function createData(MemberGrupRequest $request)
    {
        return $this->MemberGrupRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->MemberGrupRepo->getDataById($id);
    }
    public function updateDataById(MemberGrupRequest $request, $id)
    {
        return $this->MemberGrupRepo->updateDataById($request, $id);
    }
    public function deleteData($id)
    {
        return $this->MemberGrupRepo->deleteData($id);
    }
}
