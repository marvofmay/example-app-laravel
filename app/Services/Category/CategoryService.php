<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Exceptions\CategoryNotFoundException;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryService {
    
    public function prepareCategoryModel(Request $request): Category 
    {

        if (isset($request->id)) {
            try {
                $category = $this->getCategoryById($request->id);               
                $category->deleted = isset($request->deleted);
                $category->active = isset($request->active);                      
            } catch (CategoryNotFoundException $e) {                       
                return $e->render();
            }                        
        } else {
            $category = new Category(); 
        }
                        
        $category->name = $request->name;
        $category->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        $category->description = $request->description;     
        
        return $category;
    }

    public function getCategoryBySlug (string $slug)
    {
        
        $category = Category::where(['slug' => $slug])->first(); 
        if (!$category) {           
            throw new CategoryNotFoundException('Category is not found by slug: "' . $slug . '"');
        }     
        
        return $category;
    }
    
    public function getCategoryById(int $id) 
    {
        
         $category = Category::where('id', $id)->first();                
        if (!$category) {
            throw new CategoryNotFoundException('Category is not found by id: "' . $id . '"');
        }     
        
        return $category;        
    }

    public function getAllCategories() 
    {
    
        return Category::all()->where('deleted', false)->sortBy('name');
    }

    public function storeCategoryInDB (Category $category): bool 
    {
                                    
        return $category->save(); 
    }
    
    public function updateCategoryInDB (Category $category): bool 
    {  
        
        return $category->update();        
    }
    
    public function deleteCategory(int $id) 
    {
        $category = $this->getCategoryById($id);
        $category->deleted = true;
        
        return $category->update();
    }    
    
    public function getFiltredAndSortedCategories (array $params)
    {
        
        if (array_key_exists('phrase', $params)) {
            $filtredItems = Category::where('name', 'LIKE', '%' . $params['phrase'] . '%')->get();
        } else {
            $filtredItems = $this->getAllCategories();
        }

        if (array_key_exists('column', $params)) {
            if (array_key_exists('order', $params) || $params['order'] == 'asc') {
                $filtredItems = $filtredItems->sortBy($params['column']);
            }
            if ($params['order'] == 'desc') {
                $filtredItems = $filtredItems->sortByDesc($params['column']);
            }
        } else {
            $filtredItems = $filtredItems->sortBy('name');
        }
                
        return $filtredItems;
    }
}
