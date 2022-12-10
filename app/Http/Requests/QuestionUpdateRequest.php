<?php

namespace App\Http\Requests;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'survey_id'=>'required|exists:surveys,id',
            'text'=>'required',
            'is_mandatory'=>'required',
        ];
    }

    public function execute(): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $question = Question::query()->findOrFail($this->question);
        $question->update($this->input());

        return $question;
    }
}
