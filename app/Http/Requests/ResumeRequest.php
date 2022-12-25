<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'job_duration' => 'required|integer|min:0|max:255',
            'salary'       => 'required|integer',
            'salary_unit'  => 'required|integer|min:1|max:4',
            'website'      => 'string|min:2|max:255',
            'phone'        => 'required|string|min:10|max:255',
            'positions'    => 'required|string|min:2|max:255',
            'languages'    => 'required|string|min:2|max:255',
            'skills'       => 'required|string|min:2|max:255',
            'avatar'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'portfolio.*'  => 'required|mimes:jpg,jpeg,png,bmp,pdf,doc,docx|max:10000'
        ];
    }
}
