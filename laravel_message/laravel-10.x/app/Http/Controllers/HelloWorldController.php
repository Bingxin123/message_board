<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloWorldController extends Controller
{   
    public function getHello() {
        $a = 10;
        return response()->json(['message1' => 'Hello World by API'.$a]);
    }
}
