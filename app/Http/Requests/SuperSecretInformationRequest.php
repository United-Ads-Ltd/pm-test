<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuperSecretInformationRequest extends APIKeyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!parent::authorize()) {
            return false;
        }

        return $this->key->hasScope('supersecretinformation');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
