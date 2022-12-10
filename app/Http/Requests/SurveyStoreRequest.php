<?php

namespace App\Http\Requests;

use App\Models\Survey;
use Illuminate\Foundation\Http\FormRequest;

class SurveyStoreRequest extends FormRequest
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
            'title'=>'required',
            'description'=>'required',
        ];
    }

    public function execute(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
       return Survey::query()->create($this->input());
    }
}
