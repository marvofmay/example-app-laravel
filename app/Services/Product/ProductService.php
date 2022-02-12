<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Photo;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductService {
    
    public function getAllProducts() {
    
        return Product::all();
    }
    
    public function prepareProductModel(Request $request): Product 
    {

        if (isset($request->id)) {
            try {
                $product = $this->getProdcutById($request->id);               
            } catch (ProductNotFoundException $e) {                       
                return $e->render();
            }                        
        } else {
            $product = new Product(); 
        }    
        
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        $product->description = $request->description;
        
        return $product;    
    }   
    
    public function preparePhotoModel (Request $request): Photo 
    {
        
        if ($request->file()) {

        }            
        
        return $photo;
    }
    
    public function storeProductInDB (Product $product): bool 
    {
                                    
        return $product->save(); 
    }    
    
    public function getProductBySlug (string $slug)
    {
        
        $product = Product::where(['slug' => $slug])->first(); 
        if (!$product) {           
            throw new ProductNotFoundException('Product is not found by slug: "' . $slug . '"');
        }     
        
        return $product;
    }
    
    public function getProductById(int $id) 
    {
        
        $product = Product::where('id', $id)->first();                
        if (!$product) {
            throw new ProductNotFoundException('Product is not found by id: "' . $id . '"');
        }     
        
        return $product;        
    }    
    
    public function getFiltredAndSortedProducts (array $params) {
        
        if (array_key_exists('phrase', $params)) {
            $filtredItems = Product::where('name', 'LIKE', '%' . $params['phrase'] . '%')->get();
        } else {
            $filtredItems = $this->getAllProducts();
        }

        if (array_key_exists('column', $params)) {
            if (array_key_exists('order', $params) || $parmas['order'] == 'asc') {
                $filtredItems = $filtredItems->sortBy($params['column']);
            }
            if ($parmas['order'] == 'desc') {
                $filtredItems = $filtredItems->sortByDesc($params['column']);
            }
        } else {
            $filtredItems = $filtredItems->sortBy('name');
        }
                
        return $filtredItems;
    }    
}
