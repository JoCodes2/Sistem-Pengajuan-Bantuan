<?php

namespace App\Repositories;

use App\Http\Requests\SubmissionRequest;
use App\Interfaces\SubmissionInterfaces;
use App\Models\Grup;
use App\Models\MemberGrup;
use App\Models\Submission;
use App\Traits\HttpResponseTraits;

class SubmissionsRepositories implements SubmissionInterfaces
{
    use HttpResponseTraits;
    protected $grupModel;
    protected $memberGrupModel;
    protected $submissionModel;

    public function __construct(
        Grup $grupModel,
        MemberGrup $memberGrupModel,
        Submission $submissionModel
    ) {
        $this->grupModel = $grupModel;
        $this->memberGrupModel = $memberGrupModel;
        $this->submissionModel = $submissionModel;
    }

    public function getAllData()
    {
        $data = $this->submissionModel::with(['grup.member_grup'])->get();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(SubmissionRequest $request) {}
    public function getDataById($id) {}
    public function updateDataById(SubmissionRequest $request, $id) {}
    public function deleteData($id) {}
}
