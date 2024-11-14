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
        return [
            // Kolom tabel Grup
            'grup_name' => 'required|string|max:255',

            // Kolom tabel Submissions
            'status_submissions' => 'required|in:review,rejected,approved',
            'description' => 'required|string',
            'file_proposal' => 'required|file|mimes:pdf|max:2048',

            // Validasi untuk setiap anggota grup (members array)
            'members' => 'required|array', // Pastikan 'members' adalah array
            'members.*.name' => 'required|string|max:255', // Validasi untuk setiap member's name
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
            ],
            'members.*.status' => 'required|string|max:50',
        ];
    }

    /**
     * Mendapatkan pesan error kustom untuk validasi.
     */
    public function messages()
    {
        return [
            'grup_name.required' => 'Form ini wajib diisi.',
            'status_submissions.required' => 'Form ini wajib diisi.',
            'description.required' => 'Form ini wajib diisi.',
            'file_proposal.required' => 'Form ini wajib diisi.',
            'file_proposal.file' => 'File proposal harus berupa file.',
            'file_proposal.mimes' => 'File yang diupload harus dalam format pdf.',
            'file_proposal.max' => 'File proposal tidak boleh lebih dari 2 MB.',

            // Pesan error untuk setiap anggota
            'members.required' => 'Anggota grup harus diisi.',
            'members.array' => 'Anggota grup harus berupa array.',
            'members.*.name.required' => 'Nama Anggota wajib diisi.',
            'members.*.address.required' => 'Alamat Anggota wajib diisi.',
            'members.*.place_birth.required' => 'Tempat Lahir Anggota wajib diisi.',
            'members.*.date_birth.required' => 'Tanggal Lahir Anggota wajib diisi.',
            'members.*.nik.required' => 'NIK Anggota wajib diisi.',
            'members.*.nik.unique' => 'NIK Anggota sudah terdaftar dalam kelompok lain dalam 5 tahun terakhir.',
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
