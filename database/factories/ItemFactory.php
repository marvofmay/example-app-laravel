<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $customerService = new CustomerService();
        $customersIds = $customerService->getAllNotDeletedAndActiveCustomers();        
        
        $customerId = $customersIds[random_int(0, count($customersIds) - 1)];        
        
        return [
            'customer_id' => $customerId,
            'deleted' => false
        ];        
    }
}
