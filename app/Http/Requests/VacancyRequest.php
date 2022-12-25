<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacancyRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'       => 'required|string|min:4|max:255',
            'salary'      => 'required|integer|min:1',
            'salary_unit' => 'required|integer|min:1|max:5',
            'schedule'    => 'required|string|min:4|max:255',
            'position_id' => 'required|integer|min:1',
            'skills'      => 'required|string|min:2|max:255',
        ];
    }
}
