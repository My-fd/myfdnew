<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->input('category_id');
        $listings   = Listing::when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->paginate(25);

        return view('web.listings.listings', compact('listings', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('web.listings.create', compact('categories'));
    }

    public function store(ListingRequest $request)
    {
        $listing = new Listing($request->validated());
        $listing->save();

        return redirect()->route('web.listings.index')->with('success', 'Объявление успешно создано.');
    }

    public function show(Listing $listing)
    {
        return view('web.listings.show', compact('listing'));
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', compact('listing'));
    }

    public function update(ListingRequest $request, Listing $listing)
    {
        $listing->update($request->validated());

        return redirect()->route('listings.index')->with('success', 'Объявление успешно обновлено.');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->route('listings.index')->with('success', 'Объявление успешно удалено.');
    }
}