<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketInspectorStoreRequest extends FormRequest
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
            'name' => 'required|string|max:500',
            'email' => 'required|unique:ticket_inspectors,email',
            'password' => 'required|string|min:8|max:20',

        ];
    }
}
