<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->input('category_id');
        $listings = Listing::when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->paginate(25);

        return view('web.index', compact('listings', 'categories'));
    }
}
