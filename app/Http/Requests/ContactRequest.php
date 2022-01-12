<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'message' => 'required|min:3|max:1000'
        ];
    }
    
     /**
      * Get custom messages for validator errors.
      *
      * @return array
      */
    public function messages()
    {
         return [
             'email.required' => __('Pole "email" jest wymagane.'),
             'message.required' => __('Pole "wiadomość" jest wymagane.'),              
             'message.min' => __('Tekst wiadomości musi zawierać co najmniej 3 znaki.'),
             'message.max' => __('Tekst wiadomości może zawierać co najwyżej 1000 znaków.'),
         ];
    }    
}
