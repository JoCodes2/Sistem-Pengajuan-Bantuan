<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MemberGrupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'id_grup' => 'required|exists:grups,id',
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'tempat' => 'required',
            'tanggal_lahir' => 'date',
            'nik' => 'required|digits:16|unique:members,nik',
            'status' => 'required|in:active,inactive',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'id.uuid' => 'ID harus berupa UUID yang valid.',
            'id_grup.required' => 'ID Grup wajib diisi.',
            'id_grup.exists' => 'Grup yang dipilih tidak valid.',
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 100 karakter.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'ttl.required' => 'Tanggal lahir wajib diisi.',
            'ttl.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus berupa active atau inactive.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => 'Check your validation',
            'errors' => $validator->errors()
        ]));
    }
}
