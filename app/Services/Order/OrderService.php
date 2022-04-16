<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Exceptions\OrderNotFoundException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderService
 *
 * @author Marcin
 */
class OrderService {
        
    public function getAllOrders() {
    
        return Order::all();
    }
    
    public function getAllNotDeletedOrders() {
    
        return Order::all()->where('deleted', false);
    }        
    
    public function getAllNotDeletedAndActiveOrders() {
    
        return Order::all()->where('deleted', false)->where('active', true);
    }    
    
    public function getOrderById(int $id) 
    {
        
        $order = Order::where('id', $id)->first();                
        if (!$order) {
            throw new OrderNotFoundException('Order is not found by id: "' . $id . '"');
        }     
        
        return $order;        
    }    
}
