<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\SousCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', Auth::id())
            ->with(['sousCategory.category', 'user'])
            ->latest()
            ->paginate(10);
            
        return view('editeur.articles.index', compact('articles'));
    }

    public function create()
    {
        $sousCategories = SousCategory::with('category')->get();
        return view('editeur.articles.create', compact('sousCategories'));
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
            return redirect()->route('editeur.articles.preview', $article);
        }

        return redirect()->route('editeur.articles.index')->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres articles.');
        }
        
        $sousCategories = SousCategory::with('category')->get();
        return view('editeur.articles.edit', compact('article', 'sousCategories'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres articles.');
        }
        
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
            return redirect()->route('editeur.articles.preview', $article);
        }

        return redirect()->route('editeur.articles.index')->with('success', 'Article modifié avec succès.');
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres articles.');
        }
        
        $article->delete();
        return redirect()->route('editeur.articles.index')->with('success', 'Article supprimé avec succès.');
    }

    public function preview(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez prévisualiser que vos propres articles.');
        }
        
        $article->load(['sousCategory.category', 'user']);
        return view('editeur.articles.preview', compact('article'));
    }

    public function publish(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez publier que vos propres articles.');
        }
        
        $article->update([
            'statut' => 'publie',
            'date_publication' => now(),
        ]);

        return redirect()->route('editeur.articles.index')->with('success', 'Article publié avec succès.');
    }
}
