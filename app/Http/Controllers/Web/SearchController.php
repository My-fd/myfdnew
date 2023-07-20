<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search()
    {
        return view('web.index');
    }
}
