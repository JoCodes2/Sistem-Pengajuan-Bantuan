<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterfaces;
use App\Models\User;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Hash;



class UserRepositories implements UserInterfaces
{
    use HttpResponseTraits;
    protected $UserModel;
    public function __construct(User $UserModel)
    {
        $this->UserModel = $UserModel;
    }

    public function getAllData()
    {
        $data = $this->UserModel::all();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(UserRequest $request)
    {
        try {
            // Create the user
            $data = new $this->UserModel;
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));
            $data->position = $request->input('position');
            $data->role = $request->input('role');

            $data->save();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->UserModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }

    public function updateDataById(UserRequest $request, $id)
    {
        try {
            // Temukan data pengguna berdasarkan ID
            $data = $this->UserModel::findOrFail($id);

            // Perbarui data pengguna
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            // Periksa apakah password diisi dan perbarui jika ada
            if ($request->filled('password')) {
                $data->password = Hash::make($request->input('password'));
            }
            $data->position = $request->input('position');
            $data->role = $request->input('role');

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
            $data = $this->UserModel::findOrFail($id);

            // Hapus data pengguna
            $data->delete();

            return $this->success("Data pengguna berhasil dihapus.");
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
