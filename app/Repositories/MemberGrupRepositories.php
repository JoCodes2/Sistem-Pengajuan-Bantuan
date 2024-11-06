<?php

namespace App\Repositories;

use App\Http\Requests\MemberGrupRequest;
use App\Interfaces\MemberGrupInterfaces;
use App\Models\MemberGrup;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Hash;



class MemberGrupRepositories implements MemberGrupInterfaces
{
    use HttpResponseTraits;
    protected $MemberGrupModel;
    public function __construct(MemberGrup $MemberGrupModel)
    {
        $this->MemberGrupModel = $MemberGrupModel;
    }

    public function getAllData()
    {
        $data = $this->MemberGrupModel::all();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }


    public function getDataById($id)
    {
        $data = $this->MemberGrupModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }

    public function updateDataById(MemberGrupRequest $request, $id)
    {
       
    }

    public function deleteData($id)
    {
        try {
            // Temukan data pengguna berdasarkan ID
            $data = $this->MemberGrupModel::findOrFail($id);

            // Hapus data pengguna
            $data->delete();

            return $this->success("Data pengguna berhasil dihapus.");
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
