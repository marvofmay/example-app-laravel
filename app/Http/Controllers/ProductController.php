<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Photo;
use Illuminate\Support\Facades\File;

/**
 * Description of ProductController
 *
 * @author mjaroszynski
 */
class ProductController extends Controller
{

    public function list(Request $request, string $phrase = null)
    {        
        
        if (is_null($phrase)) {
            $sql1 = Product::all();
        } else {           
            $sql2 = Product::join('category', 'product.category_id', '=', 'category.id')->where('category.slug', '=', $phrase)->get('product.*');
        }    
        
        $items = is_null($phrase) ? $sql1 : $sql2;        
        
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            return $items;
        }
        
        return view(
            'Product.list', 
            ['page' => 'LISTA PRODUKTÓW', 'items' => $items]
        );
    }
    
    public function display($phrase)
    {        
        
        $item = DB::select('SELECT * FROM `product` WHERE `slug` = ?', [$phrase]); 

        return view(
            'Product.display', 
            [
                'page' => 'SZCZEGÓŁY', 
                'item' => $item[0]
            ]
        );
    }
    
    public function create()
    {
        
        return view(
            'Product.create', [
                'page' => 'FORMULARZ DODAWANIA PRODUKTU',
                'categories' => Category::all()->sortBy('name')
            ]
        );        
    }      
    
    public function save(Request $request)
    {
                    
        $request->validate(
            [
            'file' => 'required|mimes:png,jpeg,jpg|max:4096',
            'name' => 'required',
            'category_id' => 'required'
            ]
        );            
        
        $product = new Product();
        $product->name = $request->name;        
        $product->category_id = $request->category_id;        
        $product->slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        $product->description = $request->description;
        $product->save();            
                
        if ($request->file()) {
            $photo = new Photo();
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/product/' . $product->id, $fileName, 'public');
            $photo->name = $fileName;
            $photo->filepath = 'storage/' . $filePath;
            $photo->main = true;            
            $photo->product()->associate($product);
            $photo->save();           
        }        
        
        return redirect()->route('product_list');       
    }    
    
    public function edit(int $id)
    {
        
        $product = Product::find($id);
        
        return view(
            'Product.edit', [
                'page' => 'FORMULARZ EDYTOWANIA PRODUKTU',
                'product' => $product,
                'categories' => Category::all()->sortBy('name')
            ]
        );         
    }     

    public function update(int $id, Request $request)
    {        
        
        $product = Product::find($request->id);
        $product->name = $request->name;        
        $product->slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->deleted = isset($request->deleted);
        $product->active = isset($request->active);
        $product->save();
        
        $photo = $product->getMainPhoto();   
        if ($request->file()) {                     
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/product/' . $product->id, $fileName, 'public');
            $photo->name = time() . '_' . $request->file->getClientOriginalName();
            $photo->filepath = '/storage/' . $filePath;
            $photo->main = true;            
            $photo->product()->associate($product);
            $photo->save();
            File::link(storage_path('app/public'), public_path('storage'));
        }         
        
        return redirect()->route('product_list');       
    }   
    
    public function delete_product(Request $request)
    {

        //$product = Product::find($request->product_id);
        //$product->deleted = true;
        //$product->save();        
        
        return response()->json(['success' => 'Deleted record: ' . $request->product_id]);
    }
    
    public function photos($id)
    {
        
        //dd(scandir('./storage'));
        
        $product = Product::find($id);   
        $photos = $product->photos;

        return view(
            'Product.Photos.photos', [
                'page' => 'ZDJĘCIA PRODUKTU',
                'product' => $product,
                'photos' => $photos,
            ]
        );         
    }    
    
    public function addPhotos(int $id)
    {
        
        $product = Product::find($id);   

        return view(
            'Product.Photos.add', [
                'page' => 'DODAWANIE ZDJĘĆ ZDJĘĆ PRODUKTU',
                'product' => $product
            ]
        );         
    }  
    
    public function savePhotos(Request $request)
    {
        
        $request->validate(
            [
            'file' => 'required',
            'file.*' => 'mimes:png,jpeg,jpg|max:4096',
            ]
        );                 
        
        $product = Product::find($request->post('product_id'));   
        if ($request->file() && is_object($product)) {
            foreach ($request->file('file') as $file) {
                $photo = new Photo();
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/product/' . $product->id, $fileName, 'public');
                $photo->name = $fileName;
                $photo->filepath = 'storage/' . $filePath;       
                $photo->product()->associate($product);
                $photo->save();
                File::link(storage_path('app/public'), public_path('storage'));
            }
        }          

        return [];
    }       
}
