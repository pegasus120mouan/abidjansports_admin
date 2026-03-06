<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->latest()->get();
        $allCategories = Category::all();
        return view('categories.index', compact('categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'actif' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->has('actif');

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'actif' => ['boolean'],
        ]);

        if ($validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'Une catégorie ne peut pas être son propre parent.']);
        }

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->has('actif');

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
