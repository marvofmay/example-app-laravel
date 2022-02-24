<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class ProductWithCategory extends Model {

    use ElasticquentTrait;       
    
    public function getIndexName()
    {
        return 'products_with_category';
    }        
    
    public function getTypeName()
    {
        return '_doc';
    }    
}
