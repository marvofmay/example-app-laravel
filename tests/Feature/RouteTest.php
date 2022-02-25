<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    
    public function test_route_home()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    
    public function test_route_products()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }    
    
    public function test_route_categories()
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }        
    
    public function test_api_categories_json()
    {
        $response = $this->getJson('/api/categories'); 
        $response->assertStatus(200);
    }    
    
    public function test_api_products_json()
    {
        $response = $this->getJson('/api/products'); 
        $response->assertStatus(200);
    }       
    
    public function test_fragment_json_product()
    {
        $photo = \App\Models\Photo::factory()->create();        
        $productId = $photo->product->id;
        
        $response = $this->getJson('api/products/' . $productId);
        
        $response->assertJsonFragment(['id' => $productId]);
    }    
    
    public function test_fragment_json_category()
    {
        $category = \App\Models\Category::factory()->create();        
        $categoryId = $category->id;
        $categoryName = $category->name;
        
        $response = $this->getJson('api/categories/' . $categoryId);
        
        $response->assertJsonFragment(['id' => $categoryId, 'name' => $categoryName]);
    }     
    
    public function test_photo_product()
    {
        $photo = \App\Models\Photo::factory()->create();   
 
        $path = storage_path('/app/public/uploads/tests/product/' . $photo->product->id . '/' . $photo->name);
        self::assertFileExists($path);
    }    
    
}
