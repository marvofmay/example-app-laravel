<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        
        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'slug' => Str::slug($firstName . ' ' . $lastName, '-'),
            'phone' =>  $this->faker->phoneNumber(),
            'email' =>  $this->faker->email(),
            'registered' => 0,
            'active' => 0,
            'deleted' => 0
        ];
    }
}
