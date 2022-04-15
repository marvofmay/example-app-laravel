<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;

class ProductTest extends TestCase
{
    
    use RefreshDatabase;
    use CreatesApplication;    

    /** @test */
    public function isProduct():void {
        $product = new \App\Models\Product();
        
        $this->assertInstanceOf(\App\Models\Product::class, $product);
    }
    
    /** @test */
    public function name():void {
        $product = new \App\Models\Product();
        $product->name = 'lorem category';
        
        $this->assertIsString($product->name);
        $this->assertEquals('lorem category', $product->name);        
    }
    
    /** @test */
    public function description():void {
        $product = new \App\Models\Product();
        $product->description = 'lorem ipsum';
        
        $this->assertIsString($product->description);
        $this->assertEquals('lorem ipsum', $product->description);
        $this->assertNotEquals('lorem', $product->description);        
    }    
    
    /** @test */
    public function deleted():void {
        $product = new \App\Models\Product();
        $product->deleted = true;
        
        $this->assertIsBool($product->deleted);
        $this->assertEquals(true, $product->deleted);
        $this->assertNotEquals(false, $product->deleted);        
    }        
    
    /** @test */
    public function active():void {
        $product = new \App\Models\Product();
        $product->active = true;
        
        $this->assertIsBool($product->active);
        $this->assertEquals(true, $product->active);
        $this->assertNotEquals(false, $product->active);        
    }      
    
    /** @test */
    public function belongsToCategory(): void {
        $category = new \App\Models\Category();
        $category->name = 'category name';
        $category->slug = 'category-name';
        $category->description = 'category description';
        $category->save();
        
        $product = new \App\Models\Product();
        $product->category_id = $category->id;
        $this->assertEquals($category->id, $product->category_id);        
        $this->assertEquals($category->id, $product->category->id);        
    }
}
