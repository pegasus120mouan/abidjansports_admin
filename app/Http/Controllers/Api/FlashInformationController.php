<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlashInformation;
use Illuminate\Http\Request;

class FlashInformationController extends Controller
{
    public function index()
    {
        $flashInfos = FlashInformation::with('user')
            ->where('actif', true)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $flashInfos->map(function ($flash) {
                return [
                    'id' => $flash->id,
                    'titre' => $flash->titre,
                    'contenu' => $flash->contenu,
                    'icone' => $flash->icone,
                    'created_at' => $flash->created_at,
                    'auteur' => [
                        'nom' => $flash->user->nom,
                        'prenoms' => $flash->user->prenoms,
                    ],
                ];
            })
        ]);
    }
}
