<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Customer\CustomerService;
use App\Models\Order;

class OrderFactory extends Factory
{
    
    protected $model = Order::class;    
    
    /** @var $customersIds array */
    private $customersIds = [];
    
    public function __construct ($count) 
    {
        parent::__construct($count);
        
        $customerService = new CustomerService();
        $this->customersIds = $customerService->getAllNotDeletedCustomers();
    }
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $customerService = new CustomerService();
        $this->customersIds = $customerService->getAllNotDeletedCustomers();
        
        return [
            'customer_id' => $this->customersIds[rand(0, count($this->customersIds) - 1)],
            'deleted' => rand(0, 1)
        ];
    }
}
