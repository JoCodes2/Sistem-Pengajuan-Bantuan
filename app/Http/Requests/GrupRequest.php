<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GrupRequest extends FormRequest
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
            'grup_name' => 'required|max:50|unique:grups,grup_name', // Tambahkan unique:groups,grup_name

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'grup_name.required' => 'Nama wajib diisi.',
            'grup_name.max' => 'Nama tidak boleh lebih dari 50 karakter.',
            'grup_name.unique' => 'Nama grup sudah ada, silakan pilih nama lain.', // Pesan khusus untuk nama grup yang unik

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
