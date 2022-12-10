<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OptionUpdateRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'question_id'=>'required|exists:questions,id',
            'name'=>'required',
            'is_correct'=>'required|boolean',
        ];
    }

    public function execute(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $option = QuestionOption::query()->findOrFail($this->option);
        $option->update($this->input());
        return $option;
    }
}
