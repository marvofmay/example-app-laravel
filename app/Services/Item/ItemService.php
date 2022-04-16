<?php

namespace App\Services\Item;

use App\Models\Item;
use App\Exceptions\ItemNotFoundException;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemService
 *
 * @author Marcin
 */
class ItemService {
        
    public function getAllItems() {
    
        return Item::all();
    }
    
    public function getAllNotDeletedItems() {
    
        return Item::all()->where('deleted', false);
    }        
    
    public function getAllNotDeletedAndActiveItems() {
    
        return Item::all()->where('deleted', false)->where('active', true);
    }    
    
    public function getItemById(int $id) 
    {
        
        $item = Item::where('id', $id)->first();                
        if (!$item) {
            throw new ItemNotFoundException('Item is not found by id: "' . $id . '"');
        }     
        
        return $item;        
    }    
}
