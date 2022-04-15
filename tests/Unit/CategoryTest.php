<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;

class CategoryTest extends TestCase
{
    
    use RefreshDatabase;
    use CreatesApplication;    

    /** @test */
    public function isCategory():void {
        $category = new \App\Models\Category();
        
        $this->assertInstanceOf(\App\Models\Category::class, $category);
    }
    
    /** @test */
    public function name():void {
        $category = new \App\Models\Category();
        $category->name = 'lorem category';
        
        $this->assertIsString($category->name);
        $this->assertEquals('lorem category', $category->name);        
    }
    
     /** @test */
    public function description():void {
        $category = new \App\Models\Category();
        $category->description = 'lorem ipsum';
        
        $this->assertIsString($category->description);
        $this->assertEquals('lorem ipsum', $category->description);
        $this->assertNotEquals('lorem', $category->description);        
    }    
    
     /** @test */
    public function deleted():void {
        $category = new \App\Models\Category();
        $category->deleted = true;
        
        $this->assertIsBool($category->deleted);
        $this->assertEquals(true, $category->deleted);
        $this->assertNotEquals(false, $category->deleted);        
    }        
    
     /** @test */
    public function active():void {
        $category = new \App\Models\Category();
        $category->active = true;
        
        $this->assertIsBool($category->active);
        $this->assertEquals(true, $category->active);
        $this->assertNotEquals(false, $category->active);        
    }      
}
