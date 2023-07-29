<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ListingsController extends Controller
{
    public function createAd()
    {
        return view('web.listings.createAd');
    }
}