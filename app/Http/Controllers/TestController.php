<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;
use Illuminate\Http\Request;
use App\Models\ProductWithCategory;

class TestController extends Controller
{
    public function queue(Request $request)
    {
        $this->dispatch(new TestQueue('new-queue'));
    }
    
    public function elastic(Request $request)
    {

        $resaults = ProductWithCategory::searchByQuery([
            'match' => [
                'name' => 'sony bravia'
            ]
        ]);
        
        foreach ($resaults as $item) {
            echo $item->name;
        }
        
        dd($resaults);
    }        
}
