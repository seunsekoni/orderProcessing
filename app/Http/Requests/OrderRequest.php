<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'items' => 'required|array',
            'total_amount' => 'required|numeric',
            'currency' => 'required|string',
            'status' => 'required|string',
            'payment_transaction_id' => 'required|string',
            'fulfilled_at' => 'nullable|date',
            'failed_at' => 'nullable|date',
            'failed_reason' => 'nullable|string',
        ];
    }
}
