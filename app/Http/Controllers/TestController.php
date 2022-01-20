<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function queue(Request $request)
    {
        $this->dispatch(new TestQueue('new-queue'));
    }
}
