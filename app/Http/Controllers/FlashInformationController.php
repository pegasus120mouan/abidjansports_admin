<?php

namespace App\Http\Controllers;

use App\Models\FlashInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashInformationController extends Controller
{
    public function index()
    {
        $flashInfos = FlashInformation::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('flash-informations.index', compact('flashInfos'));
    }

    public function create()
    {
        return view('flash-informations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'icone' => 'required|string|max:50',
            'actif' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['actif'] = $request->has('actif');

        FlashInformation::create($validated);

        return redirect()->route('flash-informations.index')
            ->with('success', 'Flash information créée avec succès.');
    }

    public function edit(FlashInformation $flashInformation)
    {
        return view('flash-informations.edit', compact('flashInformation'));
    }

    public function update(Request $request, FlashInformation $flashInformation)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'icone' => 'required|string|max:50',
            'actif' => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        $flashInformation->update($validated);

        return redirect()->route('flash-informations.index')
            ->with('success', 'Flash information mise à jour avec succès.');
    }

    public function destroy(FlashInformation $flashInformation)
    {
        $flashInformation->delete();

        return redirect()->route('flash-informations.index')
            ->with('success', 'Flash information supprimée avec succès.');
    }

    public function toggleStatus(FlashInformation $flashInformation)
    {
        $flashInformation->update(['actif' => !$flashInformation->actif]);

        return redirect()->route('flash-informations.index')
            ->with('success', 'Statut mis à jour avec succès.');
    }
}
