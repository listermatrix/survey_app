<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OptionStoreRequest extends FormRequest
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
            'options.*.name'=>'required',
            'options.*.is_correct'=>'required|boolean',
        ];
    }

    public function execute()
    {

        $question = Question::query()->find($this->input('question_id'));

        if(in_array($question->type,['number','text']))
            throw ValidationException::withMessages(["Options are not allowed for questions of type number or text"]);

        $options = $this->input('options');

        foreach ($options as $option) {
            $question->options()->create($option);
        }
        return $question->options;
    }
}
