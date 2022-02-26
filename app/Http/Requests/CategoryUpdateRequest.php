<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema()
 */
class CategoryUpdateRequest extends FormRequest
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
     * @OA\Property(format="string", default="lorem ipsum", description="category name", property="name"),
     * @OA\Property(format="string", default="description of lorem ipsum", description="category description", property="description"),
     * @OA\Property(type="boolean", default=true, description="is categoy active", property="active"),     
     * @OA\Property(type="boolean", default=false, description="is categoy deleted", property="deleted"),     
     */
    public function rules()
    {        
        
        return [
            'name' => 'required',
            'description' => 'required',
        ];
    }
}
