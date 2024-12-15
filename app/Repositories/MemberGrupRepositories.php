<?php

namespace App\Repositories;

use App\Http\Requests\MemberGrupRequest;
use App\Interfaces\MemberGrupInterfaces;
use App\Models\Grup;
use App\Models\MemberGrup;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Hash;



class MemberGrupRepositories implements MemberGrupInterfaces
{
    use HttpResponseTraits;
    protected $MemberGrupModel;
    protected $grup;
    public function __construct(MemberGrup $MemberGrupModel, Grup $grup)
    {
        $this->grup = $grup;
        $this->MemberGrupModel = $MemberGrupModel;
    }

    public function getTotalMembers()
    {
        try {
            $count = $this->MemberGrupModel::count();
            return $this->success(['total_members' => $count]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }


    public function getAllData()
    {
        $data = $this->grup::with('member_grup')->get();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }

    public function createData(MemberGrupRequest $request)
    {
        try {
            // Create the member grup
            $data = new $this->MemberGrupModel;
            $data->id_grup = $request->input('id_grup');
            $data->name = $request->input('name');
            $data->address = $request->input('address');
            $data->place_birth = $request->input('place_birth');
            $data->date_birth = $request->input('date_birth');
            $data->nik = $request->input('nik');
            $data->status = $request->input('status');

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }


    public function getDataById($id)
    {
        $member = $this->MemberGrupModel::where('id', $id)->first();

        if ($member) {
            return $this->success($member);
        } else {
            return $this->dataNotFound();
        }
    }


    public function updateDataById(MemberGrupRequest $request, $id_member)
    {
        try {
            // Ambil member grup berdasarkan ID member
            $data = $this->MemberGrupModel::where('id', $id_member)->first();

            if (!$data) {
                return $this->dataNotFound();
            }

            $data->id_grup = $request->input('id_grup');
            $data->name = $request->input('name');
            $data->address = $request->input('address');
            $data->place_birth = $request->input('place_birth');
            $data->date_birth = $request->input('date_birth');
            $data->nik = $request->input('nik');
            $data->status = $request->input('status');
            $data->update();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }




    public function deleteData($id)
    {
        try {
            $data = $this->MemberGrupModel::findOrFail($id);

            $data->delete();

            return $this->success("Data pengguna berhasil dihapus.");
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
