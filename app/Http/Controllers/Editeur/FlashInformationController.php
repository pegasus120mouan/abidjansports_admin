<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\FlashInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashInformationController extends Controller
{
    public function index()
    {
        $flashInformations = FlashInformation::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('editeur.flash-informations.index', compact('flashInformations'));
    }

    public function create()
    {
        return view('editeur.flash-informations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'icone' => ['required', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['actif'] = true;

        FlashInformation::create($validated);

        return redirect()->route('editeur.flash-informations.index')->with('success', 'Flash information créée avec succès.');
    }

    public function edit(FlashInformation $flashInformation)
    {
        if ($flashInformation->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres flash informations.');
        }
        
        return view('editeur.flash-informations.edit', compact('flashInformation'));
    }

    public function update(Request $request, FlashInformation $flashInformation)
    {
        if ($flashInformation->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres flash informations.');
        }
        
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'icone' => ['required', 'string'],
        ]);

        $flashInformation->update($validated);

        return redirect()->route('editeur.flash-informations.index')->with('success', 'Flash information modifiée avec succès.');
    }

    public function destroy(FlashInformation $flashInformation)
    {
        if ($flashInformation->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres flash informations.');
        }
        
        $flashInformation->delete();
        return redirect()->route('editeur.flash-informations.index')->with('success', 'Flash information supprimée avec succès.');
    }

    public function toggleStatus(FlashInformation $flashInformation)
    {
        if ($flashInformation->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres flash informations.');
        }
        
        $flashInformation->update(['actif' => !$flashInformation->actif]);
        
        return redirect()->route('editeur.flash-informations.index')->with('success', 'Statut modifié avec succès.');
    }
}
