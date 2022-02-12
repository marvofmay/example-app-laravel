<?php

namespace App\Services\Photo;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;

class PhotoService {
    
    public function preparePhotoModel(Request $request, Product $product = null): Photo
    {

        if (isset($request->id) && is_null($product)) {
            try {
                $photo = $this->getPhotoById($request->id);               
            } catch (PhotoNotFoundException $e) {                       
                return $e->render();
            }                        
        } else {
            $photo = new Photo(); 
        }
                        
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads/product/' . $product->id, $fileName, 'public');
        $photo->name = $fileName;
        $photo->filepath = 'storage/' . $filePath;
        $photo->main = true;
        
        if (!is_null($product)) {
            $photo->product()->associate($product);     
        }
        
        return $photo;
    }

    public function storePhotoInDB (Photo $photo): bool 
    {
                                    
        return $photo->save(); 
    }
    
    public function getPhotoById(int $id) 
    {
        
        $photo = Photo::where('id', $id)->first();                
        if (!$photo) {
            throw new PhotoNotFoundException('Photo is not found by id: "' . $id . '"');
        }     
        
        return $photo;        
    }       

}
