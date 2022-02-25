<?php

namespace Database\Factories;

use App\Models\Photo;
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
        $product = \App\Models\Product::factory()->create();
        if (Storage::makeDirectory('public/uploads/tests/product/' . $product->id)) {
            if (is_dir('./storage/app/public/uploads/tests/product/' . $product->id)) {
                $fileName = $this->faker->image('./storage/app/public/uploads/tests/product/' . $product->id, 50, 50, null, false);
            }
        }

        return [
            'name' => $fileName,
            'filepath' => '/storage/uploads/tests/product/' . $product->id . '/' . $fileName,
            'product_id' => $product->id,
            'main' => 1,
            'active' =>  rand(0, 1),
            'deleted' => rand(0, 1)
        ];
    }
}
