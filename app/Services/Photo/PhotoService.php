<?php

namespace App\Services\Photo;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class PhotoService {
    
    public function preparePhotoModel(Request $request, UploadedFile $file, Product $product = null, bool $isMainPhoto = true): Photo
    {

        if (isset($request->id) && !is_null($product)) {
            try {               
                $photo = $product->getMainPhoto();
            } catch (PhotoNotFoundException $e) {                       
                return $e->render();
            }                        
        } else {
            $photo = new Photo(); 
        }
                
        $fileName = time() . '_' . $file->getClientOriginalName();
        if (App::environment('local')) {
            $filePath = $file->storeAs('uploads/product/' . $product->id, $fileName, 'public');
        }
        if (App::environment('testing')) {
            $filePath = $file->storeAs('uploads/tests/product/' . $product->id, $fileName, 'public');
        }            
        $photo->name = $fileName;
        $photo->filepath = 'storage/' . $filePath;     
        File::link(storage_path('app/public'), public_path('storage'));
        
        if ($isMainPhoto) {
            $photo->main = true;
        }
        
        if (!is_null($product)) {            
            $photo->product()->associate($product);     
        } 
      
        return $photo;
    }

    public function storePhotoInDB (Photo $photo): bool 
    {
                                    
        return $photo->save(); 
    }
    
    public function updatePhotoInDB (Photo $photo): bool 
    {  
        
        return $photo->update();        
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
