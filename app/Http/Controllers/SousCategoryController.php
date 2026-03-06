<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SousCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SousCategoryController extends Controller
{
    public function index()
    {
        $sousCategories = SousCategory::with('category')->latest()->get();
        $categories = Category::all();
        return view('sous-categories.index', compact('sousCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icone' => ['required', 'string', 'max:50'],
            'category_id' => ['required', 'exists:categories,id'],
            'actif' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->has('actif');

        SousCategory::create($validated);

        return redirect()->route('sous-categories.index')->with('success', 'Sous-catégorie créée avec succès.');
    }

    public function edit(SousCategory $sousCategory)
    {
        $categories = Category::all();
        return view('sous-categories.edit', compact('sousCategory', 'categories'));
    }

    public function update(Request $request, SousCategory $sousCategory)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icone' => ['required', 'string', 'max:50'],
            'category_id' => ['required', 'exists:categories,id'],
            'actif' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nom']);
        $validated['actif'] = $request->has('actif');

        $sousCategory->update($validated);

        return redirect()->route('sous-categories.index')->with('success', 'Sous-catégorie modifiée avec succès.');
    }

    public function destroy(SousCategory $sousCategory)
    {
        $sousCategory->delete();
        return redirect()->route('sous-categories.index')->with('success', 'Sous-catégorie supprimée avec succès.');
    }
}
