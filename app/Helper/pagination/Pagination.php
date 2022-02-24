<?php

namespace App\Helper\pagination;

/**
 * Description of Paggination
 *
 * @author mjaroszynski
 */
class Pagination
{
    public $itemsOnPage = 5;
    public $radius = 5;
    public $numberOfAllItems = 0;
    public $qtyFoundedItems = 0;
    public $offset = 0;
    public $numberOfAllButtonsPagination = 0;
    public $startButtons = 1;
    public $endButtons = 0;
    public $currentButton = 1;
    public $itemsToDisplay = [];
    public $filtredItems = [];

    public function __construct(\Illuminate\Database\Eloquent\Collection $filtredItems, int $numberOfAllItems = 0, int $offset = 0)
    {
        $this->filtredItems = $filtredItems;
        $this->numberOfAllItems = $numberOfAllItems;
        $this->qtyFoundedItems = count($filtredItems);
        $this->offset = $offset;
        $this->numberOfAllButtonsPagination = ceil($this->qtyFoundedItems / $this->itemsOnPage);
        $this->currentButton = ($this->offset + $this->itemsOnPage) / $this->itemsOnPage;
        $this->startButtons = ($this->currentButton - $this->radius > 0) ? $this->currentButton - $this->radius : 1;
        $this->endButtons = ($this->currentButton + $this->radius <= $this->numberOfAllButtonsPagination) ? $this->currentButton + $this->radius : $this->numberOfAllButtonsPagination;
    }
    
    public function getItemsToDisplayOnPage() {
        if (!is_null($this->offset)) {
            $this->itemsToDisplay = $this->filtredItems->skip($this->offset);
        }
        
        return $this->itemsToDisplay = $this->itemsToDisplay->take($this->itemsOnPage);            
    }
    
    public function getOffset() {
        
        return $this->offset;            
    }  
    
    public function getItemsOnPage() {
        
        return $this->itemsOnPage;            
    }       
}
