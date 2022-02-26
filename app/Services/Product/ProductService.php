<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Category;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductService {
    
    public function getAllProducts(Category $category = null) {
    
        return (is_null($category)) ? Product::all()->where('deleted', false) : $category->products;
    }
    
    public function prepareProductModel(Request $request): Product 
    {

        if (isset($request->id)) {
            try {
                $product = $this->getProductById($request->id);               
                $product->deleted = isset($request->deleted) && $request->deleted !== 'false';
                $product->active = isset($request->active) && $request->active !== 'false';                
            } catch (ProductNotFoundException $e) {                       
                return $e->render();
            }                        
        } else {
            $product = new Product();             
        }    
        
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        $product->description = $request->description;
        
        return $product;    
    }       
    
    public function storeProductInDB (Product $product): bool 
    {
                                    
        return $product->save(); 
    }    
    
    public function updateProductInDB (Product $product): bool 
    {  
        
        return $product->update();        
    }    
    
    public function deleteProduct(int $id) 
    {
        $product = $this->getProductById($id);
        $product->deleted = true;
        
        return $product->update();
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
    
    public function getFiltredAndSortedProducts (array $params, Category $category = null) {
        
        if (array_key_exists('phrase', $params)) {
            $filtredItems = Product::where('name', 'LIKE', '%' . $params['phrase'] . '%');
            if (!is_null($category)) {
                $filtredItems = $filtredItems->where('category_id', $category->id);
            }
            $filtredItems = $filtredItems->get();
        } else {
            if (is_null($category)) {
                $filtredItems = $this->getAllProducts();
            } else {
                $filtredItems = $this->getAllProducts($category);
            }    
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
