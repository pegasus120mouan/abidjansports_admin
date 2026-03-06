<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['sousCategory.category', 'user']);

        if ($request->has('sous_category_id')) {
            $query->where('sous_category_id', $request->sous_category_id);
        }

        if ($request->has('category_id')) {
            $query->whereHas('sousCategory', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        $articles = $query->where('statut', 'publie')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'data' => $articles->map(function ($article) {
                return [
                    'id' => $article->id,
                    'titre' => $article->titre,
                    'slug' => $article->slug,
                    'resume' => $article->resume,
                    'contenu' => $article->contenu,
                    'image' => $article->image ? $this->getImageUrl($article->image) : null,
                    'statut' => $article->statut,
                    'date_publication' => $article->date_publication,
                    'created_at' => $article->created_at,
                    'sous_category' => [
                        'id' => $article->sousCategory->id,
                        'nom' => $article->sousCategory->nom,
                        'slug' => $article->sousCategory->slug,
                    ],
                    'category' => [
                        'id' => $article->sousCategory->category->id,
                        'nom' => $article->sousCategory->category->nom,
                        'slug' => $article->sousCategory->category->slug,
                    ],
                    'auteur' => [
                        'id' => $article->user->id,
                        'nom' => $article->user->nom,
                        'prenoms' => $article->user->prenoms,
                    ],
                ];
            }),
            'meta' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ]
        ]);
    }

    public function show($slug)
    {
        $article = Article::with(['sousCategory.category', 'user'])
            ->where('slug', $slug)
            ->where('statut', 'publie')
            ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $article->id,
                'titre' => $article->titre,
                'slug' => $article->slug,
                'resume' => $article->resume,
                'contenu' => $article->contenu,
                'image' => $article->image ? $this->getImageUrl($article->image) : null,
                'statut' => $article->statut,
                'date_publication' => $article->date_publication,
                'created_at' => $article->created_at,
                'sous_category' => [
                    'id' => $article->sousCategory->id,
                    'nom' => $article->sousCategory->nom,
                    'slug' => $article->sousCategory->slug,
                ],
                'category' => [
                    'id' => $article->sousCategory->category->id,
                    'nom' => $article->sousCategory->category->nom,
                    'slug' => $article->sousCategory->category->slug,
                ],
                'auteur' => [
                    'id' => $article->user->id,
                    'nom' => $article->user->nom,
                    'prenoms' => $article->user->prenoms,
                ],
            ]
        ]);
    }

    public function latest(Request $request)
    {
        $limit = $request->get('limit', 5);

        $articles = Article::with(['sousCategory.category', 'user'])
            ->where('statut', 'publie')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $articles->map(function ($article) {
                return [
                    'id' => $article->id,
                    'titre' => $article->titre,
                    'slug' => $article->slug,
                    'resume' => $article->resume,
                    'image' => $article->image ? $this->getImageUrl($article->image) : null,
                    'created_at' => $article->created_at,
                    'category' => [
                        'nom' => $article->sousCategory->category->nom,
                        'slug' => $article->sousCategory->category->slug,
                    ],
                ];
            })
        ]);
    }

    public function byCategory($slug)
    {
        $articles = Article::with(['sousCategory.category', 'user'])
            ->whereHas('sousCategory.category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->where('statut', 'publie')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'data' => $articles->map(function ($article) {
                return [
                    'id' => $article->id,
                    'titre' => $article->titre,
                    'slug' => $article->slug,
                    'resume' => $article->resume,
                    'image' => $article->image ? $this->getImageUrl($article->image) : null,
                    'created_at' => $article->created_at,
                    'sous_category' => [
                        'nom' => $article->sousCategory->nom,
                        'slug' => $article->sousCategory->slug,
                    ],
                    'auteur' => [
                        'nom' => $article->user->nom,
                        'prenoms' => $article->user->prenoms,
                    ],
                ];
            }),
            'meta' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ]
        ]);
    }

    /**
     * Génère l'URL correcte pour une image stockée sur S3/MinIO
     */
    private function getImageUrl($path)
    {
        if (empty($path)) {
            return null;
        }

        // Utiliser S3 si configuré
        if (config('filesystems.default') === 's3' || config('filesystems.disks.s3.endpoint')) {
            try {
                return Storage::disk('s3')->url($path);
            } catch (\Exception $e) {
                // Fallback si S3 échoue
            }
        }
        
        // Fallback pour le stockage local
        return asset('storage/' . $path);
    }
}
