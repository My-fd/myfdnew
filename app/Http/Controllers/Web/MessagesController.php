<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function index()
    {
        return view('web.messages.index');
    }
}