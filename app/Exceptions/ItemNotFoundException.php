<?php

namespace App\Exceptions;

use Exception;

class ItemNotFoundException extends Exception
{
    
    public function __construct(string $message) { 
        parent::__construct();        
        $this->message = $message;
    }

    public function report () {
        
    }
    
    public function render () {
        
        return view('Errors.Item.itemNotFound', ['error' => $this->getMessage()]);
    }
}