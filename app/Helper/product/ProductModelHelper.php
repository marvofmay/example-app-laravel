<?php

namespace App\Helper\product;

use App\Models\Product;

/**
 * Description of ProductFormCreate
 *
 * @author mjaroszynski
 */
class ProductModelHelper extends Product
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getMainPhotoURL()
    {
        $photos = $this->product->photos;
        foreach ($photos as $photo) {
            if ($photo->main) {
                return $photo->filepath;
            }
        }

        return false;
    }
}
