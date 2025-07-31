<?php

use App\Http\Controllers\SecretiveAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/super-secret-information', [ SecretiveAPIController::class, 'superSecretInformation' ]);
Route::get('/survey-entry', [ SecretiveAPIController::class, 'surveryEntry' ]);
Route::get('/survey-all', [ SecretiveAPIController::class, 'surveyAll' ]);
