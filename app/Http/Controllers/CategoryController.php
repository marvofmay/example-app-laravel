<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Services\Category\CategoryService;
use \App\Helper\pagination\Pagination;

/**
 * Description of CategoryController
 *
 * @author mjaroszynski
 */
class CategoryController extends Controller
{
    public function list(Request $request, string $str = null)
    {
        $onPage = 3;
        $phrase = null;
        $offset = null;
        $column = null;
        $order = null;
        $filtredItems = [];

        foreach (explode('&', $str) as $item) {
            $arr = explode('=', $item);
            if (count($arr) > 1) {
                ${$arr[0]} = $arr[1];
            }
        }

        $items = (new CategoryService())->getAllCategories();
        if ($request->wantsJson() || preg_match('/^api\//', $request->path())) {
            return $items;
        }
        
        if (!is_null($phrase)) {
            $filtredItems = Category::where('name', 'LIKE', '%' . $phrase . '%')->get();
            $foundedItems = count($filtredItems);
        } else {
            $filtredItems = $items;
            $foundedItems = count($items);
        }

        if (!is_null($column)) {
            if (is_null($order) || $order == 'asc') {
                $filtredItems = $filtredItems->sortBy($column);
            }
            if ($order == 'desc') {
                $filtredItems = $filtredItems->sortByDesc($column);
            }
        } else {
            $filtredItems = $filtredItems->sortBy('name');
        }

        if (!is_null($offset)) {
            $filtredItems = $filtredItems->skip($offset);
        }
        $filtredItems = $filtredItems->take($onPage);

        return view(
            'Category.list',
            [
                'page' => 'LISTA KATEGORII',
                'page_list' => 'category_list',
                'phrase' => $phrase,
                'str' => $str,
                'items' => $items,
                'offset' => $offset,
                'filtredItems' => $filtredItems,
                'foundedItems' => $foundedItems,
                'onPage' => $onPage,
                'pagination' => new Pagination($onPage, 5, count(Category::all()), $foundedItems, $offset)
            ]
        );
    }

    public function display(string $phrase)
    {
        try {
            $category = (new CategoryService())->getCategoryBySlug($phrase);
        } catch (CategoryNotFoundException $e) {                       
            return false;
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
        (new CategoryService())->storeCategoryInDB($request);
        
        return redirect()->route('category_list');
    }

    public function edit(int $id)
    {
        try {
            $category = (new CategoryService())->getCategoryById($id);
        } catch (CategoryNotFoundException $e) {                       
            return false;
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
        try {
            $category = (new CategoryService())->getCategoryById($id);
        } catch (CategoryNotFoundException $e) {                       
            return false;
        }        
        
        (new CategoryService())->updateCategoryInDB($request, $category);

        return redirect()->route('category_list');
    }
}
