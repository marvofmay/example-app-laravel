<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Services\Product\ProductService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class PhotoFactory extends Factory
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
        
        $productService = new ProductService();
        $productsIds = $productService->getIdsActiveAndNotDeletedProducts();        
        
        $productId = $productsIds[random_int(0, count($productsIds) - 1)];
        
        if (Storage::makeDirectory('public/uploads/product/' . $productId)) {
            if (is_dir('./storage/app/public/uploads/product/' . $productId)) {
                $fileName = $this->faker->image('./storage/app/public/uploads/product/' . $productId, 50, 50, null, false);
            }
        }

        return [
            'name' => $fileName,
            'filepath' => '/storage/uploads/product/' . $productId . '/' . $fileName,
            'product_id' => $productId,
            'main' => 0,
            'active' =>  rand(0, 1),
            'deleted' => rand(0, 1)
        ];
    }
}
