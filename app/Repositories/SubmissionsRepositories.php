<?php

namespace App\Repositories;

use App\Http\Requests\SubmissionRequest;
use App\Interfaces\SubmissionInterfaces;
use App\Models\Grup;
use App\Models\MemberGrup;
use App\Models\Submission;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\DB;

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
        $data = $this->submissionModel::with(['grup', 'grup.member_grup'])->get();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }

    public function createData(SubmissionRequest $request)
    {
        try {
            DB::beginTransaction();

            $group = $this->grupModel::create([
                'grup_name' => $request->input('grup_name')
            ]);

            $submission = $this->submissionModel::create([
                'id_grup' => $group->id,
                'date' => $request->input('date'),
                'status_submissions' => $request->input('status_submissions'),
                'description' => $request->input('description'),
                'file_proposal' => $request->input('file_proposal')
            ]);

            $membersData = $request->input('members');
            foreach ($membersData as $memberData) {
                $this->memberGrupModel::create([
                    'id_grup' => $group->id,
                    'name' => $memberData['name'],
                    'address' => $memberData['address'],
                    'place_birth' => $memberData['place_birth'],
                    'date_birth' => $memberData['date_birth'],
                    'nik' => $memberData['nik'],
                    'status' => $memberData['status']
                ]);
            }

            DB::commit();

            return $this->success([
                'submissions' => $submission,
                'members' => $memberData,
                'group' => $group,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->submissionModel::with(['grup', 'grup.member_grup'])->where('id', $id)->get();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function updateDataById(SubmissionRequest $request, $id) {}
    public function deleteData($id) {}
}
