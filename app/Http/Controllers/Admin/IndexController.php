<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends BaseAdminController
{
    public function index(): Factory|View|Application
    {
        return view('admin.index');
    }
}
