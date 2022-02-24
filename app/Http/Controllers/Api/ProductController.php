<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Services\Photo\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

/**
 * Description of ProductController
 *
 * @author mjaroszynski
 */
class ProductController extends Controller
{
    
    public function products(Request $request, int $id = null): JsonResponse
    {                                 
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {            
            $ps = new ProductService(); 
            if (is_null($id)) {            
                return response()->json([$ps->getAllProducts()]);
            } else {
                return response()->json([($ps->getProductById($id))]);
            }
        }                
    }
  
    public function delete(Request $request, int $id): JsonResponse
    {                                       
        if (($request->wantsJson() && $request->isMethod('DELETE')) || preg_match('/^api\//', $request->path())) {            
            $ps = new ProductService(); 
            $product = $ps->getProductById($id);
            $product->deleted = true;
            
            return response()->json(['success' => $product->update()]);
        }                
    }   
    
    public function create(ProductRequest $request): JsonResponse
    {                                       
        if (($request->wantsJson() && $request->isMethod('POST')) || preg_match('/^api\//', $request->path())) {            
            DB::beginTransaction();
            try {        
               $productService = new ProductService();
               $product = $productService->prepareProductModel($request);
               $productService->storeProductInDB($product);

               $photoService = new PhotoService();
               $photo = $photoService->preparePhotoModel($request, $request->file, $product, true);
               $photoService->storePhotoInDB($photo);           
            } catch(\Exception $e) {
               DB::rollback();
               throw $e;
            }               
            DB::commit();                                
            
            return response()->json(['success' => true]);
        }   
        
        return response()->json(['success' => false]);
    }     
    
}
