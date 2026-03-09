<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:editeur,administrateur,analyste'],
            'signature' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $validated['avatar'] = 'users.png';
        $validated['statut'] = true;

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:editeur,administrateur,analyste'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/avatars'), $filename);
            $validated['avatar'] = $filename;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function updateName(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'Nom modifié avec succès.');
    }

    public function updateContact(Request $request, User $user)
    {
        $validated = $request->validate([
            'contact' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'signature' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:editeur,administrateur,analyste'],
            'statut' => ['required', 'boolean'],
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'Contact et statut modifiés avec succès.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password']
        ]);

        return redirect()->route('users.show', $user)->with('success', 'Mot de passe modifié avec succès.');
    }

    public function updateAvatar(Request $request, User $user)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/img/avatars'), $filename);
        
        $user->update(['avatar' => $filename]);

        return redirect()->route('users.show', $user)->with('success', 'Photo de profil modifiée avec succès.');
    }
}
