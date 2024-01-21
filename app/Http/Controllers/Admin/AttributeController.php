<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string|max:255',
            'options' => 'nullable|string',
            'comment' => 'nullable|string',
        ]);

        $attribute = new Attribute($request->all());
        $attribute->save();

        return redirect()->route('admin.attributes.index');
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string|max:255',
            'options' => 'nullable|string',
            'comment' => 'nullable|string',
        ]);

        $attribute->update($request->all());

        return redirect()->route('admin.attributes.index');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.attributes.index');
    }
}
