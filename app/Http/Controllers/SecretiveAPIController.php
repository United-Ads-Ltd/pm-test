<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperSecretInformationRequest;
use App\Http\Requests\SurveyAllRequest;
use App\Http\Requests\SurveyEntryRequest;
use App\Models\Survey;

class SecretiveAPIController extends Controller
{
    public function superSecretInformation(SuperSecretInformationRequest $request)
    {
        return 'humans are real (dont tell anyone)';
    }

    public function surveyEntry(SurveyEntryRequest $request)
    {
        $surveys = Survey::all();
        $surveys[] = Survey::create([
            'name' => $request->input('name'),
            'text' => $request->input('text'),
        ]);

        foreach ($surveys as $survey) {
            if (!$survey->hasAttribute('id')) {
                $survey->save();
            }
        }
    }

    public function surveyAll(SurveyAllRequest $request)
    {
        return Survey::all();
    }
}
