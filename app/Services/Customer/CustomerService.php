<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Exceptions\CustomerNotFoundException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerService
 *
 * @author Marcin
 */
class CustomerService {
        
    public function getAllCustomers() {
    
        return Customer::all();
    }
    
    public function getAllNotDeletedCustomers() {
    
        return Customer::all()->where('deleted', false);
    }        
    
    public function getAllNotDeletedAndActiveCustomers() {
    
        return Customer::all()->where('deleted', false)->where('active', true);
    }    
    
    public function getCustomerBySlug (string $slug)
    {
        
        $customer = Customer::where(['slug' => $slug])->first(); 
        if (!$customer) {           
            throw new CustomerNotFoundException('Customer is not found by slug: "' . $slug . '"');
        }     
        
        return $customer;
    }
    
    public function getCustomerById(int $id) 
    {
        
        $customer = Customer::where('id', $id)->first();                
        if (!$customer) {
            throw new CustomerNotFoundException('Customer is not found by id: "' . $id . '"');
        }     
        
        return $customer;        
    }    
}
