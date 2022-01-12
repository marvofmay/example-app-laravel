<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helper\category\CategoryFormCreate;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Requests\CategoryRequest;

/**
 * Description of CategoryController
 *
 * @author mjaroszynski
 */
class CategoryController extends Controller
{

    public function list(Request $request, string $str = null)
    {        

        $onPage = 2;
        $phrase = null;
        $offset = 0;
        $column = null;
        $order = null;
        $filtredItems = [];
        
        foreach (explode('&', $str) as $item) {
            $arr = explode('=', $item);
            if (count($arr) > 1) {
                ${$arr[0]} = $arr[1];
            }
        }     
        
        $items = Category::all();        
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            return $items;
        } 
        if (isset($phrase) && !is_null($phrase)) {                    
            $filtredItems = Category::where('name', 'LIKE', '%' . $phrase . '%')->get();          
            $foundedItems = count($filtredItems);
        } else {
            $filtredItems = $items;
            $foundedItems = count($items);
        } 
        
        if (isset($column) && !is_null($column)) {
            if (is_null($order) || $order == 'asc') {
                $filtredItems = $filtredItems->sortBy($column);          
            } 
            if ($order == 'desc') {
                $filtredItems = $filtredItems->sortByDesc($column);          
            }             
        } else {
            $filtredItems = $filtredItems->sortBy('name');          
        }     
          
        if (isset($offset)) {
            $filtredItems = $filtredItems->skip($offset);          
        }                           
        $filtredItems = $filtredItems->take($onPage);                                       
        
        return view(
            'Category.list', 
            [
                'page' => 'LISTA KATEGORII', 
                'phrase' => $phrase,
                'str' => $str,               
                'items' => $items,                 
                'offset' => $offset,
                'filtredItems' => $filtredItems,  
                'foundedItems' => $foundedItems,                
                'onPage' => $onPage,
                'allButtonsPagination' => ceil($foundedItems / $onPage),
                'pagination' => new \App\Helper\pagination\Pagination($onPage, 5, count(Category::all()), $foundedItems, $offset)
            ]
        );
    }
    
    public function display(string $phrase)
    {        
        
        $category = DB::select('SELECT * FROM `category` WHERE `slug` = ?', [$phrase]); 

        return view(
            'Category.display', 
            [
                'page' => 'SZCZEGÓŁY', 
                'category' => $category[0]
            ]
        );
    }   
    
    public function create()
    {
       
        return view(
            'Category.create', [
                'page' => 'FORMULARZ DODAWANIA KATEGORII',
            ]
        );        
    }    
    
    public function save(CategoryRequest $request)
    {                    
        
        $category = new Category();
        $category->name = $request->name;        
        $category->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        $category->description = $request->description;
        $category->save();
        
        return redirect()->route('category_list');       
    }
    
    public function edit(int $id)
    {
        
        $res = Category::where('id', $id)->get();
        
        return view(
            'Category.edit', [
                'page' => 'FORMULARZ EDYTOWANIA KATEGORII',
                'data'=> $res[0]
            ]
        );         
    }        
    
    public function update(int $id, CategoryRequest $request)
    {
        
        $category = Category::find($request->id);
        $category->name = $request->name;        
        $category->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        $category->description = $request->description;
        $category->deleted = isset($request->deleted);
        $category->active = isset($request->active);
        $category->save();
        
        return redirect()->route('category_list');       
    }    
    
}
