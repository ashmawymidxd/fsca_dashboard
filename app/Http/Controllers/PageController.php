<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function icons(){
        return view('pages.icons');
    }

}
