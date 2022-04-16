<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoMainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'main' => 1,
            'active' =>  1,
            'deleted' => 0
        ];
    }
    
    public function makeFolder($productId, $fileName) {                        
        
        return $this->state(function ($attributes) use ($productId, $fileName) {
            
            return [
                'name' => $fileName,
                'filepath' => '/storage/uploads/product/' . $productId . '/' . $fileName,
                'product_id' => $productId,            
            ];
        });    
    }
}
