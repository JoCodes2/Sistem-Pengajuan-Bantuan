<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SubmissionRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     */
    public function rules()
    {
        // Hanya terapkan validasi ini jika request berasal dari 'v1/submissions/create'
        if ($this->is('v1/submissions/create')) {
            return [
                'grup_name' => 'required|string|max:255',
                'file_proposal' => 'required|file|mimes:pdf|max:2048',
                'members' => 'required|array|min:1',
                'members.*.name' => 'required|string|max:255',
                'members.*.address' => 'required|string|max:255',
                'members.*.place_birth' => 'required|string|max:255',
                'members.*.date_birth' => 'required|date',
                'members.*.nik' => [
                    'required',
                    'string',
                    'max:16',
                    Rule::unique('member_grups', 'nik')->where(function ($query) {
                        $cutoffDate = Carbon::now()->subYears(5);
                        return $query->where('created_at', '>=', $cutoffDate);
                    }),
                    function ($attribute, $value, $fail) {
                        $niks = $this->input('members', []);
                        $nikCount = array_count_values(array_column($niks, 'nik'))[$value] ?? 0;
                        if ($nikCount > 1) {
                            $fail('NIK Anggota tidak boleh sama dalam 1 kelompok.');
                        }
                    },
                ],

                'members.*.status' => 'required|string|max:50',
            ];
        }

        // Jika route bukan 'v1/submissions/create', tidak ada validasi
        return [];
    }

    /**
     * Pesan error kustom untuk validasi.
     */
    public function messages()
    {
        return [
            'grup_name.required' => 'Nama kelompok wajib diisi.',
            'file_proposal.required' => 'File proposal wajib diupload.',
            'file_proposal.file' => 'File proposal harus berupa file.',
            'file_proposal.mimes' => 'File yang diupload harus dalam format pdf.',
            'file_proposal.max' => 'File proposal tidak boleh lebih dari 2 MB.',

            'members.required' => 'Anggota grup harus diisi.',
            'members.array' => 'Anggota grup harus berupa array.',
            'members.min' => 'Minimal harus ada satu anggota grup.',
            'members.*.name.required' => 'Nama Anggota wajib diisi.',
            'members.*.address.required' => 'Alamat Anggota wajib diisi.',
            'members.*.place_birth.required' => 'Tempat Lahir Anggota wajib diisi.',
            'members.*.date_birth.required' => 'Tanggal Lahir Anggota wajib diisi.',
            'members.*.nik.required' => 'NIK Anggota wajib diisi.',
            'members.*.nik.max' => 'Nik maksimal 16 karakter.',
            'members.*.nik.unique' => 'NIK Anggota sudah terdaftar dalam kelompok lain dalam 5 tahun terakhir.',
            'members.*.nik.custom' => 'NIK Anggota tidak boleh duplikat dalam kelompok yang sama.',

            'members.*.status.required' => 'Status Anggota wajib diisi.',
        ];
    }

    /**
     * Menangani validasi yang gagal.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => 'Periksa validasi Anda',
            'errors' => $validator->errors()
        ]));
    }
}
