<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\FlashInformation;
use App\Models\Journal;
use App\Models\SousCategory;
use App\Models\User;
use App\Models\Visite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_articles' => Article::count(),
            'articles_publies' => Article::where('statut', 'publie')->count(),
            'articles_brouillon' => Article::where('statut', 'brouillon')->count(),
            'total_journaux' => Journal::count(),
            'journaux_disponibles' => Journal::where('statut', 'disponible')->count(),
            'journaux_epuises' => Journal::where('statut', 'epuise')->count(),
            'total_utilisateurs' => User::count(),
            'total_editeurs' => User::where('role', 'editeur')->count(),
            'total_categories' => Category::count(),
            'total_sous_categories' => SousCategory::count(),
            'flash_actives' => FlashInformation::where('actif', true)->count(),
            'stock_total_journaux' => Journal::sum('stock'),
        ];

        // Articles par mois (6 derniers mois)
        $articlesParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Article::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $articlesParMois[] = [
                'mois' => $date->translatedFormat('M Y'),
                'count' => $count,
            ];
        }

        // Articles par catégorie
        $articlesParCategorie = Category::with('sousCategories')->get()->map(function ($category) {
            $sousIds = $category->sousCategories->pluck('id');
            $count = Article::whereIn('sous_category_id', $sousIds)->count();
            return [
                'nom' => $category->nom,
                'count' => $count,
            ];
        });

        // Derniers articles
        $derniersArticles = Article::with(['user', 'sousCategory.category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers journaux
        $derniersJournaux = Journal::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers utilisateurs
        $derniersUtilisateurs = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Articles publiés aujourd'hui
        $articlesAujourdhui = Article::whereDate('created_at', Carbon::today())->count();

        // Articles cette semaine
        $articlesCetteSemaine = Article::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Statistiques des visites
        $visitesAujourdhui = Visite::whereDate('created_at', Carbon::today())->count();
        $visiteursUniquesAujourdhui = Visite::whereDate('created_at', Carbon::today())
            ->distinct('ip_hash')->count('ip_hash');
        $visitesCetteSemaine = Visite::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $visitesCeMois = Visite::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();

        // Visites par jour (7 derniers jours)
        $visitesParJour = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Visite::whereDate('created_at', $date)->count();
            $visitesParJour[] = [
                'jour' => $date->translatedFormat('D d'),
                'count' => $count,
            ];
        }

        // Top pays visiteurs
        $topPays = Visite::select('pays', 'code_pays', DB::raw('count(*) as total'))
            ->whereNotNull('pays')
            ->groupBy('pays', 'code_pays')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Articles les plus lus
        $articlesPlusLus = Article::where('statut', 'publie')
            ->orderByDesc('vues')
            ->limit(10)
            ->get();

        // Total des vues
        $totalVues = Article::sum('vues');

        return view('dashboard', compact(
            'stats',
            'articlesParMois',
            'articlesParCategorie',
            'derniersArticles',
            'derniersJournaux',
            'derniersUtilisateurs',
            'articlesAujourdhui',
            'articlesCetteSemaine',
            'visitesAujourdhui',
            'visiteursUniquesAujourdhui',
            'visitesCetteSemaine',
            'visitesCeMois',
            'visitesParJour',
            'topPays',
            'articlesPlusLus',
            'totalVues'
        ));
    }
}
