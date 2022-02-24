<?php

namespace App\Exceptions;

use Exception;

class CategoryNotFoundException extends Exception
{
    
    public function __construct(string $message) { 
        parent::__construct();        
        $this->message = $message;
    }

    public function report () {
        
    }
    
    public function render () {
        
        return view('errors.category.categoryNotFound', ['error' => $this->getMessage()]);
    }
}