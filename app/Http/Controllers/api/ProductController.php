<?php

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
    
   /**
    * @OA\Get(
    *    path="/api/products",
    *    @OA\Parameter(        
    *        description="ID of product",
    *        in="path",
    *        name="id",
    *        required=false,
    *        example=3,
    *        @OA\Schema(
    *            type="integer",
    *            nullable=true
    *       )
    *    ),
    *    summary="Get list of products or one product by ID of product",
    *    description="Get products or product by ID",
    *    tags={"products"},
    *    @OA\Response(response="200", description="get products or product")
    * )
    */    
    public function products(Request $request, int $id = null): JsonResponse
    {                                 
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {            
            $ps = new ProductService(); 
            if (is_null($id)) {            
                return response()->json($ps->getAllProducts());
            } else {
                return response()->json($ps->getProductById($id));
            }
        }                
    }
  
   /**
    * @OA\Delete(
    *    path="/api/products/{id}",
    *    @OA\Parameter(
    *        description="ID of product",
    *        in="path",
    *        name="id",
    *        required=true,
    *        example=3,
    *        @OA\Schema(type="integer")
    *    ),
    *    summary="Delete product by ID of product",    
    *    description="Delete product by ID",
    *    tags={"products"},
    *    security={ {"sanctum": {}} },
    *    @OA\Response(
    *        response="200", description="Delete product and get response message - true / false",
    *        @OA\JsonContent(
    *            @OA\Property(property="success", type="boolean", example="true")
    *        )
    *    ),
    *    @OA\Response(
    *        response="401", description="User is unauthenticated",
    *        @OA\JsonContent(
    *            @OA\Property(property="message", type="string", example="Unauthenticated")
    *        )
    *    )
    * )
    */        
    public function delete(Request $request, int $id): JsonResponse
    {                                       
        if (($request->wantsJson() && $request->isMethod('DELETE')) || preg_match('/^api\//', $request->path())) {            
            $ps = new ProductService(); 
            $product = $ps->getProductById($id);
            $product->deleted = true;
            
            return response()->json(['success' => $product->update()]);
        }                
    }   
    
   /**
    * @OA\POST(
    *    path="/api/products/",
    *    summary="Create new product",
    *    description="Create new product",
    *    tags={"products"},
    *    security={ {"sanctum": {}} },
    *    @OA\RequestBody(
    *        @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *                type="object",
    *                ref="#/components/schemas/ProductRequest",
    *            )
    *        )
    *    ),    
    *    @OA\Response(
    *        response="200", description="response message - true / false",
    *        @OA\JsonContent(
    *            @OA\Property(property="success", type="boolean", example="true")
    *        )
    *    ),
    *    @OA\Response(
    *        response="401", description="User is unauthenticated",
    *        @OA\JsonContent(
    *            @OA\Property(property="message", type="string", example="Unauthenticated")
    *        )
    *    )
    * )
    */      
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
