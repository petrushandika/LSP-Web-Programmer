<?php

namespace App\Http\Requests\Catalogue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Request DTO untuk pembuatan catalogue baru
 * 
 * @package App\Http\Requests\Catalogue
 */
class CreateCatalogueRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999'
            ],
            'is_publish' => [
                'required',
                'boolean'
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:2000'
            ],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120' // 5MB
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul catalogue wajib diisi',
            'title.min' => 'Judul catalogue minimal 3 karakter',
            'title.max' => 'Judul catalogue maksimal 255 karakter',
            'user_id.required' => 'User ID wajib diisi',
            'user_id.exists' => 'User tidak ditemukan',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'price.max' => 'Harga terlalu besar',
            'is_publish.required' => 'Status publish wajib diisi',
            'is_publish.boolean' => 'Status publish harus true atau false',
            'description.required' => 'Deskripsi wajib diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'description.max' => 'Deskripsi maksimal 2000 karakter',
            'image.required' => 'Gambar wajib diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 5MB'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    /**
     * Get validated data as array
     *
     * @return array
     */
    public function getValidatedData(): array
    {
        return $this->validated();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert string boolean to actual boolean
        if ($this->has('is_publish')) {
            $this->merge([
                'is_publish' => filter_var($this->is_publish, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            ]);
        }
    }
}