<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AnswerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function expectsJson(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'question_id'=>'required|exists:questions,id',
            'answers'=>'required|array',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function execute()
    {
        $question = Question::query()->find($this->input('question_id'));
        $questionAns = QuestionAnswer::query();


        if(in_array($question->type,['single','multiple']))
        {
            $this->validate(['answers.*.question_option_id'=>'required'], $this->input());

            $answers =   $this->input('answers');

            foreach($answers as $answer)
            {
                $questionAns->create([
                    'question_id' => $this->input('question_id'),
                    'question_option_id' => $answer['question_option_id']
                ]);
            }
        }
        else  if($question->type == 'text')
        {
            $this->validate(['answers.text'=>'required'], $this->input());

            if($question->answers->isNotEmpty())
               throw ValidationException::withMessages(["Question with id {$this->input('question_id')} has already been answered"]);

            $answer =   $this->input('answers');

            $questionAns->create([
                'question_id' => $this->input('question_id'),
                'answer' => $answer['text']
            ]);


        }
        else {

            $this->validate(['answers.number'=>'required|integer'], $this->input());
            $answer =   $this->input('answers');

            if($question->answers->isNotEmpty())
                throw ValidationException::withMessages(["Question with id {$this->input('question_id')} has already been answered"]);


            $questionAns->create([
                'question_id' => $this->input('question_id'),
                'answer' => $answer['number']
            ]);
        }

        return $question->refresh()->answers;
    }
}
