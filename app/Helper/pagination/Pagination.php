<?php

namespace App\Helper\pagination;

/**
 * Description of Paggination
 *
 * @author mjaroszynski
 */
class Pagination
{
    public $itemsOnPage = 2;
    public $radius = 2;
    public $numberOfAllItems = 0;
    public $foundedItems = 0;
    public $offset = 0;
    public $numberOfAllButtonsPagination = 0;
    public $startButtons = 1;
    public $endButtons = 0;
    public $numberOfAllButtons = 0;
    public $currentButton = 1;

    public function __construct(int $itemsOnPage, int $radius, int $numberOfAllItems, int $foundedItems, ?int $offset)
    {
        $this->itemsOnPage = $itemsOnPage;
        $this->radius = $radius;
        $this->numberOfAllItems = $numberOfAllItems;
        $this->foundedItems = $foundedItems;
        $this->offset = $offset;
        $this->numberOfAllButtonsPagination = ceil($foundedItems / $itemsOnPage);
        $this->currentButton = ($this->offset + $this->itemsOnPage) / $this->itemsOnPage;
        $this->startButtons = ($this->currentButton - $this->radius > 0) ? $this->currentButton - $this->radius : 1;
        $this->endButtons = ($this->currentButton + $this->radius <= $this->numberOfAllButtonsPagination) ? $this->currentButton + $this->radius : $this->numberOfAllButtonsPagination;
    }
}
