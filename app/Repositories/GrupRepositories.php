<?php

namespace App\Repositories;

use App\Http\Requests\GrupRequest;
use App\Interfaces\GrupInterfaces;
use App\Models\Grup;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Hash;



class GrupRepositories implements GrupInterfaces
{
    use HttpResponseTraits;
    protected $GrupModel;
    public function __construct(Grup $GrupModel)
    {
        $this->GrupModel = $GrupModel;
    }

    public function getAllData()
    {
        $data = $this->GrupModel::all();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(GrupRequest $request)
    {
        try {
            // Create the Grup
            $data = new $this->GrupModel;
            $data->grup_name = $request->input('grup_name');
            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->GrupModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }

    public function updateDataById(GrupRequest $request, $id)
    {
        try {
            // Temukan data pengguna berdasarkan ID
            $data = $this->GrupModel::findOrFail($id);

            // Perbarui data pengguna
            $data->grup_name = $request->input('grup_name');

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        try {
            // Temukan data pengguna berdasarkan ID
            $data = $this->GrupModel::findOrFail($id);

            // Hapus data pengguna
            $data->delete();

            return $this->success("Data pengguna berhasil dihapus.");
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
