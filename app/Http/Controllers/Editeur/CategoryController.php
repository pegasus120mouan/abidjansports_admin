<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SousCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('sousCategories')->orderBy('nom')->paginate(10);
        return view('editeur.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()->route('editeur.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function storeSousCategory(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'icone' => ['nullable', 'string'],
        ]);

        SousCategory::create($validated);

        return redirect()->route('editeur.categories.index')->with('success', 'Sous-catégorie créée avec succès.');
    }
}
