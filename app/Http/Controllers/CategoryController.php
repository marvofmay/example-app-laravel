<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Services\Category\CategoryService;
use \App\Helper\pagination\Pagination;
use App\Helper\request\RequestHelper;
use App\Exceptions\CategoryNotFoundException;
use PDF;

/**
 * Description of CategoryController
 *
 * @author mjaroszynski
 */
class CategoryController extends Controller
{
    public function list(Request $request, string $str = null)
    {
                     
        if (!is_null($str)) {
            $params = RequestHelper::getParamsFromURL($str);
            $filtredItems = (new CategoryService())->getFiltredAndSortedCategories($params);
        } else {
            $filtredItems = (new CategoryService())->getAllCategories();
        }        
        
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            return $filtredItems;
        }                
        
        $pagination = new Pagination(
            $filtredItems, 
            count((new CategoryService())->getAllCategories()),
            (isset($params) && array_key_exists('offset', $params)) ? $params['offset'] : 0
        );  
        $itemsToDisplayOnPage = $pagination->getItemsToDisplayOnPage();        
        
        return view(
            'Category.list',
            [
                'page' => 'LISTA KATEGORII',
                'page_list' => 'category_list',
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

    public function display(string $phrase)
    {
        try {
            $category = (new CategoryService())->getCategoryBySlug($phrase);
        } catch (CategoryNotFoundException $e) {              
            return $e->render();
        }

        return view(
            'Category.display',
            [
                'page' => 'SZCZEGÓŁY',
                'category' => $category
            ]
        );
    }

    public function create()
    {
        return view(
            'Category.create',
            [
                'page' => 'FORMULARZ DODAWANIA KATEGORII',
            ]
        );
    }

    public function save(CategoryRequest $request)
    {
        $cs = new CategoryService();
        $category = $cs->prepareCategoryModel($request);
        $cs->storeCategoryInDB($category);
        
        return redirect()->route('category_list');
    }

    public function edit(int $id)
    {
        $cs = new CategoryService(); 
        try {
            $category = $cs->getCategoryById($id);
        } catch (CategoryNotFoundException $e) {        
            return $e->render();
        }

        return view(
            'Category.edit',
            [
                'page' => 'FORMULARZ EDYTOWANIA KATEGORII',
                'data' => $category
            ]
        );
    }

    public function update(int $id, CategoryRequest $request)
    {
        $cs = new CategoryService();                
        $category = $cs->prepareCategoryModel($request);       
        $cs->updateCategoryInDB($category);

        return redirect()->route('category_list');
    }
    
    public function generatePDF(int $id) {
        
        $cs = new CategoryService();   
        
        try {
            $category = $cs->getCategoryById($id);
        } catch (CategoryNotFoundException $e) {        
            return $e->render();
        }
        
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'category' => $category
        ];
        //dd($data);
        $pdf = PDF::loadView('category/pdf/pdf', $data);
  
        return $pdf->download('category.pdf');   
    }
}
