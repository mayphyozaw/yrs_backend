<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletReduceAmountStoreRequest extends FormRequest
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
            'wallet_id'=>'required',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'wallet_id.required' => "The wallet field is required"
        ];
    }
}
