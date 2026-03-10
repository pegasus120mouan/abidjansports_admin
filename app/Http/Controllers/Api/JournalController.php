<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $query = Journal::disponible()->recent();

        if ($request->has('limit')) {
            $journals = $query->limit($request->limit)->get();
        } else {
            $journals = $query->paginate(12);
        }

        $data = $journals instanceof \Illuminate\Pagination\LengthAwarePaginator 
            ? $journals->items() 
            : $journals;

        return response()->json([
            'data' => collect($data)->map(function ($journal) {
                return $this->formatJournal($journal);
            }),
            'meta' => $journals instanceof \Illuminate\Pagination\LengthAwarePaginator ? [
                'current_page' => $journals->currentPage(),
                'last_page' => $journals->lastPage(),
                'per_page' => $journals->perPage(),
                'total' => $journals->total(),
            ] : null,
        ]);
    }

    public function show($slug)
    {
        $journal = Journal::where('slug', $slug)->first();

        if (!$journal) {
            return response()->json(['error' => 'Journal non trouvé'], 404);
        }

        return response()->json([
            'data' => $this->formatJournal($journal),
        ]);
    }

    public function latest(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $journals = Journal::disponible()
            ->recent()
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $journals->map(function ($journal) {
                return $this->formatJournal($journal);
            }),
        ]);
    }

    private function formatJournal($journal)
    {
        return [
            'id' => $journal->id,
            'titre' => $journal->titre,
            'slug' => $journal->slug,
            'description' => $journal->description,
            'image' => $journal->image_url,
            'fichier_pdf' => $journal->pdf_url,
            'prix' => $journal->prix,
            'prix_formatte' => number_format($journal->prix, 0, ',', ' ') . ' FCFA',
            'date_publication' => $journal->date_publication->format('Y-m-d'),
            'date_publication_formatte' => $journal->date_publication->format('d/m/Y'),
            'numero' => $journal->numero,
            'statut' => $journal->statut,
            'stock' => $journal->stock,
            'disponible' => $journal->statut === 'disponible' && $journal->stock > 0,
        ];
    }
}
