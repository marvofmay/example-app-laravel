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
    
}
