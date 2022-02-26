<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema()
 */
class ProductUpdateRequest extends FormRequest
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
     * @OA\Property(format="string", default="lorem ipsum dolor", description="product name", property="name"),
     * @OA\Property(format="string", default="description of lorem ipsum dolor", description="product description", property="description"),
     * @OA\Property(format="integer", default="1", description="category of product", property="category_id"),
     * @OA\Property(type="file", description="main photo of product", property="file"),
     * @OA\Property(type="boolean", default=true, description="is product active", property="active"),     
     * @OA\Property(type="boolean", default=false, description="is product deleted", property="deleted")  
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
