<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Exceptions\CategoryNotFoundException;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryService {
    
    public function __construct () {
        
    }
    
    public function getCategoryBySlug (string $slug) {
        
        $category = Category::where(['slug' => $slug])->first(); 
        if (!$category) {
            throw new CategoryNotFoundException('Category is not found by slug: "' . $slug . '"');
        }     
        
        return $category;
    }
    
    public function getCategoryById(int $id) {
        
         $category = Category::where('id', $id)->first();                
        if (!$category) {
            throw new CategoryNotFoundException('Category is not found by id: "' . $id . '"');
        }     
        
        return $category;        
    }

    public function getAllCategories() {
    
        return Category::all();
    }

    public function storeCategoryInDB (Request $request) {
                
        $category = new Category();
        $category->name = $request->name;
        $category->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        $category->description = $request->description;        
        
        return $category->save(); 
    }
    
    public function updateCategoryInDB (Request $request, Category $category) {
        
        $category->name = $request->name;
        $category->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        $category->description = $request->description;
        $category->deleted = isset($request->deleted);
        $category->active = isset($request->active);
        
        return $category->save();        
    }
    
    public function getFiltredCategories () {
        
    }
}
