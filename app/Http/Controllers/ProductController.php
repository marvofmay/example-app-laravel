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
use App\Services\Product\ProductService;
use App\Services\Photo\PhotoService;
use \App\Helper\pagination\Pagination;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\PhotoRequest;
use App\Helper\request\RequestHelper;
use App\Exceptions\ProductNotFoundException;
use Illuminate\View\View;
use PDF;

/**
 * Description of ProductController
 *
 * @author mjaroszynski
 */
class ProductController extends Controller
{
    
    /**
     * 
     * @param Request $request
     * @param string $str
     * @return View
     */
    public function list(Request $request, string $str = null): View
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
                'fullPath' => $request->fullUrl(),
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

    /**
     * 
     * @param type $phrase
     * @return View
     */
    public function display($phrase): View
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
    
    /**
     * 
     * @param Request $request
     * @param string $slug
     * @param string $str
     * @return View
     */
    public function productsByCategory(Request$request, string $slug, string $str = null): View
    {        
        
        $category = Category::where(['slug' => $slug])->first();
        
        if (!is_null($str)) {
            $params = RequestHelper::getParamsFromURL($str);
            $filtredItems = (new ProductService())->getFiltredAndSortedProducts($params, $category);
        } else {
            $filtredItems = $category->products;
        }              

        $pagination = new Pagination(
            $filtredItems, 
            count((new ProductService())->getAllProducts($category)),
            (isset($params) && array_key_exists('offset', $params)) ? $params['offset'] : 0
        );  
        $itemsToDisplayOnPage = $pagination->getItemsToDisplayOnPage();        
        
        return view(
            'Product.list',
            [
                'page' => 'LISTA PRODUKTÓW WZGLĘDEM KATEGORII "' . $slug . '"',
                'fullPath' => $request->fullUrl(),
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

    /**
     * 
     * @return View
     */
    public function create(): View
    {
        return view(
            'Product.create',
            [
                'page' => 'FORMULARZ DODAWANIA PRODUKTU',
                'categories' => Category::all()->sortBy('name')
            ]
        );
    }
    
    /**
     * 
     * @param ProductRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function save(ProductRequest $request): RedirectResponse
    {
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
        
        return redirect()->route('product_list');        
    }

    /**
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {        

        $ps = new ProductService(); 
        try {
            $product= $ps->getProductById($id);
        } catch (ProductNotFoundException $e) {        
            return $e->render();
        }        
        
        return view(
            'Product.edit',
            [
                'page' => 'FORMULARZ EDYTOWANIA PRODUKTU',
                'product' => $product,
                'categories' => Category::all()->sortBy('name')
            ]
        );
    }

    /**
     * 
     * @param int $id
     * @param ProductRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(int $id, ProductRequest $request): RedirectResponse
    {
     
        DB::beginTransaction();
        
        try {        
           $productService = new ProductService();
           $product = $productService->prepareProductModel($request);
           $productService->updateProductInDB($product);
           
           $photoService = new PhotoService();
           $photo = $photoService->preparePhotoModel($request, $product);
           $photoService->updatePhotoInDB($photo);                 
        } catch(\Exception $e) {
           DB::rollback();
           throw $e;
        }   
        
        DB::commit();

        return redirect()->route('product_list');
    }

    /**
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {

        $ps = new ProductService();
        $res = $ps->deleteProduct($request->product_id);
        
        return response()->json([
            'success' => 'Produkt został skasowany.'
        ]);                    
    }

    /**
     * 
     * @param int $id
     * @return View
     */
    public function photos(int $id): View
    {

        $product = Product::find($id);
        $photos = $product->photos;

        return view('Product.Photos.photos', [
            'page' => 'ZDJĘCIA PRODUKTU',
            'product' => $product,
            'photos' => $photos,
        ]);
    }

    /**
     * 
     * @param int $id
     * @return View
     */
    public function addPhotos(int $id): View
    {
        $productService = new ProductService();
        $product = $productService->getProductById($id);

        return view('Product.Photos.add', [
                'page' => 'DODAWANIE ZDJĘĆ ZDJĘĆ PRODUKTU',
                'product' => $product
        ]);
    }

    /**
     * 
     * @param PhotoRequest $request
     * @return RedirectResponse
     */
    public function savePhotos(PhotoRequest $request): RedirectResponse
    {
                
        $productService = new ProductService();
        $product = $productService->getProductById($request->post('product_id'));
        
        DB::beginTransaction();
        
        try {
            foreach ($request->file('file') as $file) {
                $photoService = new PhotoService();
                $photo = $photoService->preparePhotoModel($request, $file, $product, false);
                $photoService->storePhotoInDB($photo);           
            }                   
        } catch(\Exception $e) {
           DB::rollback();
           throw $e;
        }   
        
        DB::commit();        
        
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
            'title' => 'Przykład pdf\'a produktu.',
            'product' => $product
        ];
        
        $pdf = PDF::loadView('product/pdf/pdf', $data);
  
        return $pdf->download('product.pdf');   
    }    
}
