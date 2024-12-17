<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProsedurRequest extends FormRequest
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
            'name' => 'required',
            'file_prosedur' => 'required|file|mimes:pdf|max:2048',

        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Nama prosedur wajib diisi',
            'file_prosedur.required' => 'File prosedur wajib diupload.',
            'file_prosedur.file' => 'File prosedur harus berupa file.',
            'file_prosedur.mimes' => 'File yang diupload harus dalam format pdf.',
            'file_prosedur.max' => 'File prosedur tidak boleh lebih dari 2 MB.',

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
