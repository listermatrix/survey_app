<?php

namespace App\Http\Requests;

use App\Models\Survey;
use Illuminate\Foundation\Http\FormRequest;

class SurveyUpdateRequest extends FormRequest
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


    public function rules()
    {
        return [
            'title'=>'required',
            'description'=>'required',
        ];
    }

    public function execute(): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $survey = Survey::query()->findOrFail($this->survey);
        $survey->update($this->input());

        return $survey;
    }
}
