<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ManagerController extends BaseAdminController
{
    public function list(Request $request): Factory|View|Application
    {
        return view('admin.managers.list', [
            'managers' => Manager::query()->paginate($request->get('limit'))
        ]);
    }
}
