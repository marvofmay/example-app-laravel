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
