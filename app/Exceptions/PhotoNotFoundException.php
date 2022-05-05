<?php

namespace App\Exceptions;

use Exception;

class PhotoNotFoundException extends Exception
{
    
    public function __construct(string $message) { 
        parent::__construct();        
        $this->message = $message;
    }

    public function report () {
        
    }
    
    public function render () {
        
        return view('Errors.Photo.photoNotFound', ['error' => $this->getMessage()]);
    }
}
