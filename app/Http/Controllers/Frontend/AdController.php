<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdController extends Controller
{
    //
    public function addPostPage()
    {
        return view('frontend.pages.ad.post-ad');
    }
}
