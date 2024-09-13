<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class StoreGiftCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         // Ensure the user is authenticated
         return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:16',
            'pin' => 'required|string|max:3',
            'brand' => 'required|string|max:255',
            'value' => 'required|string',
            'exchange_rate' => 'required|string',
            'currency' => 'required|string|max:10',
            'exchange_currency' => 'required|string|max:10',
            'expiration_date' => 'required|date',
            'photo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You are not authorized to perform this action.');
    }
}
