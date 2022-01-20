<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = 'product ' . $this->faker->uuid();

        return [
            'name' => $name,
            'description' => 'product description for ' . $name,
            'slug' => Str::slug($name),
            'category_id' => \App\Models\Category::factory()->create(),
            'active' =>  rand(0, 1),
            'deleted' => rand(0, 1)
        ];
    }
}
