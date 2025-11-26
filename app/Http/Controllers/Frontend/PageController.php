<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function homePage()
    {
       return view("frontend.pages.home");
    }
}
