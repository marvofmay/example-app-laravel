<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function queue(Request $request)
    {
        $this->dispatch(new TestQueue('new-queue'));
    }
    
    public function elastic(Request $request)
    {
        $client = ClientBuilder::create()->build();
        $params['index'] = 'products_with_category';
        $resaults = $client->search($params);
        
        dd($resaults['hits']['hits']);
    }    
}
