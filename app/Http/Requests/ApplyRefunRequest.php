<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

class ApplyRefunRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'reason' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'reason' => '原因',
        ];
    }
}
