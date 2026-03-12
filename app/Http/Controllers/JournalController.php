<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::recent()->paginate(10);
        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        return view('journals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fichier_pdf' => 'nullable|mimes:pdf|max:10240',
            'prix' => 'required|numeric|min:0',
            'date_publication' => 'required|date',
            'numero' => 'nullable|string|max:50',
            'statut' => 'required|in:disponible,epuise,archive',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['titre'] . '-' . ($validated['numero'] ?? now()->format('Ymd')));

        $disk = config('filesystems.default');
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('journaux', $disk);
        }

        if ($request->hasFile('fichier_pdf')) {
            $validated['fichier_pdf'] = $request->file('fichier_pdf')->store('journaux/pdfs', $disk);
        }

        Journal::create($validated);

        return redirect()->route('journals.index')->with('success', 'Journal ajouté avec succès.');
    }

    public function show(Journal $journal)
    {
        return view('journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        return view('journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fichier_pdf' => 'nullable|mimes:pdf|max:10240',
            'prix' => 'required|numeric|min:0',
            'date_publication' => 'required|date',
            'numero' => 'nullable|string|max:50',
            'statut' => 'required|in:disponible,epuise,archive',
            'stock' => 'required|integer|min:0',
        ]);

        $disk = config('filesystems.default');
        
        if ($request->hasFile('image')) {
            if ($journal->image) {
                Storage::disk($disk)->delete($journal->image);
            }
            $validated['image'] = $request->file('image')->store('journaux', $disk);
        }

        if ($request->hasFile('fichier_pdf')) {
            if ($journal->fichier_pdf) {
                Storage::disk($disk)->delete($journal->fichier_pdf);
            }
            $validated['fichier_pdf'] = $request->file('fichier_pdf')->store('journaux/pdfs', $disk);
        }

        $journal->update($validated);

        return redirect()->route('journals.index')->with('success', 'Journal mis à jour avec succès.');
    }

    public function destroy(Journal $journal)
    {
        $disk = config('filesystems.default');
        
        if ($journal->image) {
            Storage::disk($disk)->delete($journal->image);
        }
        if ($journal->fichier_pdf) {
            Storage::disk($disk)->delete($journal->fichier_pdf);
        }

        $journal->delete();

        return redirect()->route('journals.index')->with('success', 'Journal supprimé avec succès.');
    }
}
