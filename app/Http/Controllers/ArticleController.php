<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\SousCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['sousCategory.category', 'user'])->latest()->paginate(10);
        $sousCategories = SousCategory::with('category')->get();
        return view('articles.index', compact('articles', 'sousCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $sousCategories = SousCategory::with('category')->get();
        return view('articles.create', compact('categories', 'sousCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'resume' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sous_category_id' => ['required', 'exists:sous_categories,id'],
            'statut' => ['required', 'in:brouillon,publie'],
        ]);

        $validated['slug'] = Str::slug($validated['titre']);
        $validated['user_id'] = Auth::id();

        // Si prévisualisation, forcer le statut brouillon
        if ($request->input('action') === 'preview') {
            $validated['statut'] = 'brouillon';
        }

        if ($validated['statut'] === 'publie') {
            $validated['date_publication'] = now();
        }

        if ($request->hasFile('image')) {
            $disk = config('filesystems.default', 'public');
            $validated['image'] = $request->file('image')->store('articles', $disk);
        }

        $article = Article::create($validated);

        // Rediriger vers la prévisualisation si demandé
        if ($request->input('action') === 'preview') {
            return redirect()->route('articles.preview', $article);
        }

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $sousCategories = SousCategory::with('category')->get();
        return view('articles.edit', compact('article', 'categories', 'sousCategories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'resume' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sous_category_id' => ['required', 'exists:sous_categories,id'],
            'statut' => ['required', 'in:brouillon,publie'],
        ]);

        $validated['slug'] = Str::slug($validated['titre']);

        // Si prévisualisation, forcer le statut brouillon
        if ($request->input('action') === 'preview') {
            $validated['statut'] = 'brouillon';
        }

        if ($validated['statut'] === 'publie' && $article->statut !== 'publie') {
            $validated['date_publication'] = now();
        }

        if ($request->hasFile('image')) {
            $disk = config('filesystems.default', 'public');
            $validated['image'] = $request->file('image')->store('articles', $disk);
        }

        $article->update($validated);

        // Rediriger vers la prévisualisation si demandé
        if ($request->input('action') === 'preview') {
            return redirect()->route('articles.preview', $article);
        }

        return redirect()->route('articles.index')->with('success', 'Article modifié avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    public function preview(Article $article)
    {
        $article->load(['sousCategory.category', 'user']);
        return view('articles.preview', compact('article'));
    }

    public function publish(Article $article)
    {
        $article->update([
            'statut' => 'publie',
            'date_publication' => now(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Article publié avec succès.');
    }
}
