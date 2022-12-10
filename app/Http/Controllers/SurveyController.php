<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyStoreRequest;
use App\Http\Requests\SurveyUpdateRequest;
use App\Models\QuestionOption;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $survey = Survey::query()->with('questions')->latest()->paginate();
        return $this->response($survey);
    }


    public function store(SurveyStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $survey  = $request->execute();

        return $this->response($survey,'Survey successfully created');
    }


    public function show(Survey $survey): \Illuminate\Http\JsonResponse
    {
        return $this->response($survey->load('questions'),'Survey successfully retrieved');
    }


    public function update(SurveyUpdateRequest $request):  \Illuminate\Http\JsonResponse
    {
        $survey  = $request->execute();
        return $this->response($survey->load('questions'),'Survey successfully updated');
    }


    public function results(Survey $survey): \Illuminate\Http\JsonResponse
    {
        return $this->response( $survey->load(['questions','questions.options', 'questions.answers']),'Survey details successfully');
    }

    public function destroy(Survey $survey):  \Illuminate\Http\JsonResponse
    {
        $survey->questions()->answers()->delete();
        $survey->questions()->options()->delete();
        $survey->questions()->delete();
        $survey->delete();

        return $this->response("",'Survey successfully deleted');
    }

}
