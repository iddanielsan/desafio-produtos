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
            "user" => ["required", "array"],
            "user.name" => ["required", "string"],
            "user.email" => ["required", "email", "unique:users,email," . $this->customer->user->id],
            "user.password" => ["required", "string"],
            "date_of_birth" => ["required", "date"],
            "address" => ["required", "string"],
            "complement" => ["nullable", "string"],
            "city" => ["required", "string"],
            "state" => ["required", "string"],
            "zip" => ["required", "string"],
        ];
    }
}
