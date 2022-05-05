<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Product\ProductService;
use App\Services\Order\OrderService;

class ItemFactory extends Factory
{
        
    /** @var $productsIds array */
    private $productsIds = [];
    
    /** @var $ordersIds array */
    private $ordersIds = [];    
    
    public function __construct ($count) 
    {
        parent::__construct($count);
        
        $orderService = new OrderService();
        foreach ($orderService->getAllNotDeletedOrders() as $order) {
            $this->ordersIds[] = $order->id;
        }
        
        $productService = new ProductService();
        foreach ($productService->getAllNotDeletedAndActiveProducts() as $product) {
            $this->productsIds[] = $product->id;
        }
        
    }
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {      
        //dd($this->ordersIds);
        return [
            'product_id' => $this->productsIds[rand(0, count($this->productsIds) - 1)],
            'order_id' =>  $this->ordersIds[rand(0, count($this->ordersIds) - 1)],
            'deleted' => false,
        ];        
    }
}
