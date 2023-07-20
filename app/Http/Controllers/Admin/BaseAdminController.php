<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BaseAdminController extends Controller
{
    /**
     * Flush error message through session
     * @param string $message
     * @return void
     */
    protected function flushError(string $message): void
    {
        Session::flash('error', $message);
    }

    /**
     * Flush success message through session
     * @param string $message
     * @return void
     */
    protected function flushSuccess(string $message): void
    {
        Session::flash('success', $message);
    }
}
