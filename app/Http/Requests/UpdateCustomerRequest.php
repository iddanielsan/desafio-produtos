<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            "date_of_birth" => ["required", "date"],
            "address" => ["required", "string"],
            "complement" => ["nullable", "string"],
            "city" => ["required", "string"],
            "state" => ["required", "string"],
            "zip" => ["required", "string"],
        ];
    }
}
