<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperSecretInformationRequest;
use Illuminate\Http\Request;

class SecretiveAPIController extends Controller
{
    public function superSecretInformation(SuperSecretInformationRequest $request)
    {
        return 'my password is "blink182unblink"';
    }
}
