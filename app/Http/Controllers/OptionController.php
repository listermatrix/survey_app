<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $question = QuestionOption::query()->with('question')->latest()->paginate();
        return $this->response($question,"Options retrieved successfully");
    }


    public function store(OptionStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $question  = $request->execute();
        return $this->response($question->load('question'),'Options successfully created');
    }


    public function show(QuestionOption $option): \Illuminate\Http\JsonResponse
    {
        return $this->response($option->load('question'),'Option successfully retrieved');
    }


    public function update(OptionUpdateRequest $request):  \Illuminate\Http\JsonResponse
    {
        $question  = $request->execute();
        return $this->response($question->load('question'),'Options successfully updated');
    }


    public function destroy(QuestionOption $option):  \Illuminate\Http\JsonResponse
    {
        $option->delete();
        return $this->response("",'Options successfully deleted');
    }


}
