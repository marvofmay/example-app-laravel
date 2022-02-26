<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CategoryRequest;

/**
 * Description of CategoryController
 *
 * @author mjaroszynski
 */
class CategoryController extends Controller
{
    
   /**
    * @OA\Get(
    *    path="/api/categories",
    *    @OA\Parameter(
    *        description="ID of category",
    *        in="path",
    *        name="id",
    *        required=false,
    *        example=3,
    *        @OA\Schema(
    *            type="integer",
    *            nullable=true
    *       )
    *    ),
    *    summary="Get list of categories or one category by ID of category",
    *    description="Get category or category by ID",
    *    tags={"categories"},
    *    @OA\Response(response="200", description="get category or category")
    * )
    */        
    public function categories(Request $request, int $id = null): JsonResponse
    {                                 
        if (($request->wantsJson()  && $request->isMethod('GET')) || preg_match('/^api\//', $request->path())) {            
            $cs = new CategoryService(); 
            if (is_null($id)) {            
                return response()->json([$cs->getAllCategories()]);
            } else {
                return response()->json([$cs->getCategoryById($id)]);
            }
        }                
        
        return response()->json(['success' => false]);
    }
    
   /**
    * @OA\Delete(
    *    path="/api/categories/{id}",
    *    @OA\Parameter(
    *        description="ID of category",
    *        in="path",
    *        name="id",
    *        required=true,
    *        example=3,
    *        @OA\Schema(type="integer")
    *    ),
    *    summary="Delete category by ID of category",
    *    description="Delete category by ID",
    *    tags={"categories"},
    *    security={ {"sanctum": {}} },
    *    @OA\Response(
    *        response="200", description="Delete category and get response message - true / false",
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
            $cs = new CategoryService(); 
            $category = $cs->getCategoryById($id);
            $category->deleted = true;
            
            return response()->json(['success' => $category->update()]);
        }   
        
        return response()->json(['success' => false]);
    }   
    
   /**
    * @OA\POST(
    *    path="/api/categories/",
    *    summary="Create new category",
    *    description="Create new category",
    *    tags={"categories"},
    *    security={ {"sanctum": {}} },
    *    @OA\RequestBody(
    *        @OA\MediaType(
    *            mediaType="application/x-www-form-urlencoded",
    *            @OA\Schema(
    *                type="object",
    *                ref="#/components/schemas/CategoryRequest",
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
    public function create(CategoryRequest $request): JsonResponse
    {                                       
        if (($request->wantsJson() && $request->isMethod('POST')) || preg_match('/^api\//', $request->path())) {            
            $cs = new CategoryService(); 
            $category = $cs->prepareCategoryModel($request);            
            
            return response()->json(['success' => $cs->storeCategoryInDB($category)]);
        }   
        
        return response()->json(['success' => false]);
    }     

}
