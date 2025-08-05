<?php

namespace App\Http\Requests;

class SurveyEntryRequest extends APIKeyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!parent::authorize()) {
            return false;
        }

        return $this->key->hasScope('survey-entry');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'text' => 'required|string',
        ];
    }
}
