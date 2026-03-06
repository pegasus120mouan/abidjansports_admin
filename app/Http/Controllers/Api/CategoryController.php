<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('sousCategories')
            ->where('actif', true)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'data' => $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'nom' => $category->nom,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'sous_categories' => $category->sousCategories->map(function ($sous) {
                        return [
                            'id' => $sous->id,
                            'nom' => $sous->nom,
                            'slug' => $sous->slug,
                            'icone' => $sous->icone,
                        ];
                    }),
                ];
            })
        ]);
    }

    public function show($slug)
    {
        $category = Category::with('sousCategories')
            ->where('slug', $slug)
            ->where('actif', true)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $category->id,
                'nom' => $category->nom,
                'slug' => $category->slug,
                'description' => $category->description,
                'sous_categories' => $category->sousCategories->map(function ($sous) {
                    return [
                        'id' => $sous->id,
                        'nom' => $sous->nom,
                        'slug' => $sous->slug,
                        'icone' => $sous->icone,
                    ];
                }),
            ]
        ]);
    }
}
