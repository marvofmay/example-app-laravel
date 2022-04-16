<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->word;

        return [
            'name' => $name,
            'description' => 'category description for ' . $name,
            'slug' => Str::slug('category ' . $name, '-'),
            'active' => $this->faker->numberBetween(0, 1),
            'deleted' => 0
        ];
    }
}
