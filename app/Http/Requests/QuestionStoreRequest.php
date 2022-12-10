<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionStoreRequest extends FormRequest
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
            'survey_id'=>'required|exists:surveys,id',
            'text'=>'required',
            'type' => ["required", Rule::in(['text','single','multiple','number'])],
            'is_mandatory'=>'required',
        ];
    }

    public function execute(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
       return Question::query()->create($this->input());
    }
}
