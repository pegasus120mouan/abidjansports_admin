<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VisiteService;
use Illuminate\Http\Request;

class VisiteController extends Controller
{
    protected VisiteService $visiteService;

    public function __construct(VisiteService $visiteService)
    {
        $this->visiteService = $visiteService;
    }

    public function enregistrer(Request $request)
    {
        $request->validate([
            'article_id' => 'nullable|integer',
            'type_page' => 'nullable|string|in:article,boutique,accueil,categorie,autre',
        ]);

        $visite = $this->visiteService->enregistrerVisite(
            $request,
            $request->input('article_id'),
            $request->input('type_page', 'autre')
        );

        return response()->json([
            'success' => true,
            'message' => 'Visite enregistrée',
        ]);
    }
}
