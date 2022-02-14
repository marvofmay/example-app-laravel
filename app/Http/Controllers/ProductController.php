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
use App\Models\Photo;
use App\Services\Product\ProductService;
use App\Services\Photo\PhotoService;
use \App\Helper\pagination\Pagination;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\PhotoRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Support\Facades\File;
use PDF;

/**
 * Description of ProductController
 *
 * @author mjaroszynski
 */
class ProductController extends Controller
{
    public function list(Request $request, string $str = null)
    {
        if (!is_null($str)) {
            $params = RequestHelper::getParamsFromURL($str);
            $filtredItems = (new ProductService())->getFiltredAndSortedProducts($params);
        } else {
            $filtredItems = (new ProductService())->getAllProducts();
        }        
        
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            return $filtredItems;
        }                
        
        $pagination = new Pagination(
            $filtredItems, 
            count((new ProductService())->getAllProducts()),
            (isset($params) && array_key_exists('offset', $params)) ? $params['offset'] : 0
        );  
        $itemsToDisplayOnPage = $pagination->getItemsToDisplayOnPage();        
        
        return view(
            'Product.list',
            [
                'page' => 'LISTA PRODUKTÓW',
                'page_list' => 'product_list',
                'str' => $str,
                'offset' => $pagination->getOffset(),
                'filtredItems' => $filtredItems,
                'itemsToDisplayOnPage' => $itemsToDisplayOnPage,
                'foundedItems' => count($filtredItems),
                'onPage' => $pagination->getItemsOnPage(),
                'pagination' => $pagination
            ]
        );
           
    }

    public function display($phrase)
    {
        try {
            $product = (new ProductService())->getProductBySlug($phrase);
        } catch (ProductNotFoundException $e) {              
            return $e->render();
        }

        return view(
            'Product.display',
            [
                'page' => 'SZCZEGÓŁY',
                'item' => $product
            ]
        );
    }

    public function create()
    {
        return view(
            'Product.create',
            [
                'page' => 'FORMULARZ DODAWANIA PRODUKTU',
                'categories' => Category::all()->sortBy('name')
            ]
        );
    }

    public function save(ProductRequest $request)
    {
        DB::beginTransaction();
        
        try {        
           $productService = new ProductService();
           $product = $productService->prepareProductModel($request);
           $productService->storeProductInDB($product);
           
           $photoService = new PhotoService();
           $photo = $photoService->preparePhotoModel($request, $product);
           $photoService->storePhotoInDB($photo);           
        } catch(\Exception $e) {
           DB::rollback();
           throw $e;
        }   
        
        DB::commit();
        
        return redirect()->route('product_list');        
    }

    public function edit(int $id)
    {
        $product = Product::find($id);

        return view(
            'Product.edit',
            [
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

        return response()->json([
            'success' => 'Deleted record: ' . $request->product_id
        ]);
    }

    public function photos($id)
    {

        $product = Product::find($id);
        $photos = $product->photos;

        return view('Product.Photos.photos', [
            'page' => 'ZDJĘCIA PRODUKTU',
            'product' => $product,
            'photos' => $photos,
        ]);
    }

    public function addPhotos(int $id)
    {
        $productService = new ProductService();
        $product = $productService->getProductById($id);

        return view('Product.Photos.add', [
                'page' => 'DODAWANIE ZDJĘĆ ZDJĘĆ PRODUKTU',
                'product' => $product
        ]);
    }

    public function savePhotos(PhotoRequest $request)
    {
                
        $productService = new ProductService();
        $product = $productService->getProductById($request->post('product_id'));
        
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

        return redirect('/product/' . $request->post('product_id') . '/photos');
    }

    public function generatePDF(int $id) {
        
        $ps = new ProductService();   
        
        try {
            $product = $ps->getProductById($id);
        } catch (ProductNotFoundException $e) {        
            return $e->render();
        }
        
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'product' => $product
        ];
        //dd($data);
        $pdf = PDF::loadView('product/pdf/pdf', $data);
  
        return $pdf->download('product.pdf');   
    }    
}
