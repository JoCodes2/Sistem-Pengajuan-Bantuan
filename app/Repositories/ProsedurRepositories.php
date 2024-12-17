<?php

namespace App\Repositories;

use App\Http\Requests\ProsedurRequest;
use App\Interfaces\ProsedurInterfaces;
use App\Models\Prosedur;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;





class ProsedurRepositories implements ProsedurInterfaces
{
    use HttpResponseTraits;
    protected $ProsedurModel;
    public function __construct(Prosedur $ProsedurModel)
    {
        $this->ProsedurModel = $ProsedurModel;
    }

    public function getAllData()
    {
        $data = $this->ProsedurModel::all();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }
    public function createData(ProsedurRequest $request)
    {
        try {
            $data = new $this->ProsedurModel;

            $data->file_prosedur = $request->input('file_prosedur');

            if ($request->hasFile('file_prosedur')) {
                $data->name = $request->input('name');
                $file = $request->file('file_prosedur');
                $extension = $file->getClientOriginalExtension();
                $filename = 'FILE-PROSEDUR-' . Str::random(15) . '.' . $extension;
                Storage::makeDirectory('uploads/file-prsedur');
                $file->move(public_path('uploads/file-prsedur'), $filename);
                $data->file_prosedur = $filename;
            }

            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function getDataById($id)
    {
        $data = $this->ProsedurModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }

    public function updateDataById(ProsedurRequest $request, $id)
    {
        try {
            $data = $this->ProsedurModel::where('id', $id)->first();
            if (!$data) {
                return $this->dataNotFound();
            }

            $data->file_prosedur = $request->input('file_prosedur');

            if ($request->hasFile('file_prosedur')) {
                $data->name = $request->input('name');
                $file = $request->file('file_prosedur');
                $extension = $file->getClientOriginalExtension();
                $filename = 'FILE-PROSEDUR-' . Str::random(15) . '.' . $extension;

                // Create directory if it doesn't exist
                Storage::makeDirectory('uploads/file-prosedur');

                // Move the new file to the public/uploads/file-prosedur directory
                $file->move(public_path('uploads/file-prosedur'), $filename);

                // Remove the old file if it exists
                $oldFilePath = public_path('uploads/file-prosedur/' . $data->file_prosedur);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Update the file_prosedur field in the model
                $data->file_prosedur = $filename;
            }

            // Update other fields in the model
            $data->update();

            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        try {
            // Temukan data pengguna berdasarkan ID
            $data = $this->ProsedurModel::findOrFail($id);

            // Hapus data pengguna
            $data->delete();

            return $this->success("Data pengguna berhasil dihapus.");
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
