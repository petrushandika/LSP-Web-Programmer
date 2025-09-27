<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Request DTO untuk update order
 * 
 * @package App\Http\Requests\Order
 */
class UpdateOrderRequest extends FormRequest
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
            'user_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id'
            ],
            'catalogue_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:catalogues,id'
            ],
            'status' => [
                'sometimes',
                'required',
                'string',
                'in:pending,approved,rejected,completed,cancelled'
            ],
            'notes' => [
                'sometimes',
                'nullable',
                'string',
                'max:1000'
            ],
            'order_date' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:today'
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
            'user_id.required' => 'User ID wajib diisi',
            'user_id.exists' => 'User tidak ditemukan',
            'catalogue_id.required' => 'Catalogue ID wajib diisi',
            'catalogue_id.exists' => 'Catalogue tidak ditemukan',
            'status.required' => 'Status order wajib diisi',
            'status.in' => 'Status harus salah satu dari: pending, approved, rejected, completed, cancelled',
            'notes.max' => 'Catatan maksimal 1000 karakter',
            'order_date.date' => 'Format tanggal tidak valid',
            'order_date.after_or_equal' => 'Tanggal order tidak boleh kurang dari hari ini'
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