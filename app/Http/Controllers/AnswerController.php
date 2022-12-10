<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerStoreRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AnswerController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $question = QuestionAnswer::query()->with('question')->latest()->paginate();
        return $this->response($question,"Answers retrieved successfully");
    }


    /**
     * @throws ValidationException
     */
    public function store(AnswerStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $answer  = $request->execute();
        return $this->response($answer->load('question'),'answer successfully added');
    }


    public function show(QuestionAnswer $answer): \Illuminate\Http\JsonResponse
    {
        return $this->response($answer->load('question'),'Option successfully retrieved');
    }


    public function update(AnswerUpdateRequest $request):  \Illuminate\Http\JsonResponse
    {
        $question  = $request->execute();
        return $this->response($question->load('question'),'Options successfully updated');
    }
}
