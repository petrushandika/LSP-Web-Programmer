<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * Request DTO untuk update user
 * 
 * @package App\Http\Requests\User
 */
class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user');
        
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:80',
                'min:2'
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
                'max:255'
            ],
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'confirmed'
            ],
            'phone_number' => [
                'sometimes',
                'required',
                'string',
                'max:15',
                'regex:/^[0-9+\-\s]+$/'
            ],
            'role' => [
                'sometimes',
                'required',
                'string',
                'in:admin,client,vendor'
            ],
            'address' => [
                'sometimes',
                'nullable',
                'string',
                'max:500'
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
            'name.required' => 'Nama wajib diisi',
            'name.min' => 'Nama minimal 2 karakter',
            'name.max' => 'Nama maksimal 80 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'phone_number.regex' => 'Format nomor telepon tidak valid',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role harus salah satu dari: admin, client, vendor',
            'address.max' => 'Alamat maksimal 500 karakter'
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
}