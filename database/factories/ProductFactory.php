<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Services\Category\CategoryService;
use Database\Factories\PhotoMainFactory;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = 'product ' . $this->faker->unique()->word();
        
        $categoryService = new CategoryService();
        $categoriesIds = $categoryService->getIdsActiveAndNotDeletedCategories();

        return [
            'name' => $name,
            'description' => 'product description for ' . $name,
            'slug' => Str::slug('product ' . $name, '-'),
            'category_id' => $categoriesIds[random_int(0, count($categoriesIds) - 1)],
            'active' =>  1,
            'deleted' => 0
        ];
    }
    
    public function mainPhoto()
   {                        
        
        return $this->afterCreating(function (Product $product) { 
            
            if (Storage::makeDirectory('public/uploads/product/' . $product->id)) {
                if (is_dir('./storage/app/public/uploads/product/' . $product->id)) {
                    $fileName = $this->faker->image('./storage/app/public/uploads/product/' . $product->id, 50, 50, null, false);            
                }
            }            
            
            PhotoMainFactory::new()->makeFolder($product->id, $fileName)->create();            
        });
    }    
}
