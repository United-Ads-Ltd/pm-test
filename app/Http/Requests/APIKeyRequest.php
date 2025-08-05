<?php

namespace App\Http\Requests;

use App\Models\APIKey;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property APIKey $key
 */
class APIKeyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!str_starts_with($this->header('Authorization', ''), 'Bearer ')) {
            return false;
        }
        
        $key = json_decode(base64_decode(str_replace('Bearer ', '', $this->header('Authorization'))));
        if ($key === null) {
            return false;
        }
        $key = APIKey::validate($key->name, $key->key);
        if ($key === false) {
            return false;
        }
        $this->key = $key;

        return true;
    }
}
