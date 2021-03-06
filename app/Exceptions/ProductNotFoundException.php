<?php

namespace App\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
    
    public function __construct(string $message) { 
        parent::__construct();        
        $this->message = $message;
    }

    public function report () {
        
    }
    
    public function render () {
        
        return view('Errors.Product.productNotFound', ['error' => $this->getMessage()]);
    }
}
