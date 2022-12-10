<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $question = Question::query()->with(['survey','options'])->latest()->paginate();
        return $this->response($question);
    }


    public function store(QuestionStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $question  = $request->execute();
        return $this->response($question->load('survey'),'Question successfully created');
    }


    public function update(QuestionUpdateRequest $request):  \Illuminate\Http\JsonResponse
    {
        $question  = $request->execute();
        return $this->response($question->load('survey'),'Question successfully updated');
    }


    public function show(Question $question): \Illuminate\Http\JsonResponse
    {
        return $this->response($question->load('survey'),'Question successfully retrieved');
    }


    public function destroy(Question $question):  \Illuminate\Http\JsonResponse
    {
        $question->delete();
        return $this->response("",'Question successfully deleted');
    }
}
