<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\FlashInformation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'articles' => Article::where('user_id', $user->id)->count(),
            'articles_publies' => Article::where('user_id', $user->id)->where('statut', 'publie')->count(),
            'articles_brouillon' => Article::where('user_id', $user->id)->where('statut', 'brouillon')->count(),
            'categories' => Category::count(),
            'flash_informations' => FlashInformation::where('user_id', $user->id)->count(),
        ];
        
        $derniers_articles = Article::where('user_id', $user->id)
            ->with('sousCategory.category')
            ->latest()
            ->take(5)
            ->get();
        
        return view('editeur.dashboard', compact('stats', 'derniers_articles'));
    }
}
