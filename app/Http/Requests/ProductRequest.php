<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            return [
                'file' => 'required|mimes:png,jpeg,jpg|max:4096',
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required'
            ];            
        }
        if ($this->method() === 'PUT') {
            return [
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required'
            ];            
        }        
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('Pole "name" jest wymagane.'),
            'description.required' => __('Pole "opis" jest wymagane.'),
            'category_id.required' => __('Pole "kategoria" jest wymagane.'),
            'file.required' => __('Wskaż plik.'),
            'file.mimes' => __('Dopuszczalne formaty: png, jpeg, jpg'),
            'file.max' => __('Maksymalny rozmiar pliku: 4096kb'),            
         ];
    }    
}
