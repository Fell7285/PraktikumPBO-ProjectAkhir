<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(TransactionType::class)],
            'amount' => ['required', 'integer', 'min:1'],
            'destination_account_number' => ['required_if:type,transfer', 'string', 'size:10'],
            'description' => ['nullable', 'string', 'max:100'],
            'bill_code' => ['required_if:type,bill', 'string', 'max:30'],
        ];
    }
}

