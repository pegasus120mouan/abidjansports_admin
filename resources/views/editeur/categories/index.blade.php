@extends('layout.editeur-dashboard')

@section('page-title', 'Catégories')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Liste des catégories</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Sous-catégories</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>
                                    <strong>{{ $category->nom }}</strong>
                                    @if($category->description)
                                        <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @forelse($category->sousCategories as $sous)
                                        <span class="badge bg-secondary me-1">
                                            @if($sous->icone)
                                                <i class="bi {{ $sous->icone }}"></i>
                                            @endif
                                            {{ $sous->nom }}
                                        </span>
                                    @empty
                                        <span class="text-muted">Aucune</span>
                                    @endforelse
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">
                                    Aucune catégorie
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($categories->hasPages())
            <div class="card-footer">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Nouvelle catégorie</h6>
            </div>
            <form action="{{ route('editeur.categories.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg"></i> Créer
                    </button>
                </div>
            </form>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Nouvelle sous-catégorie</h6>
            </div>
            <form action="{{ route('editeur.sous-categories.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie parente <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sous_nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="sous_nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="icone" class="form-label">Icône</label>
                        <select name="icone" id="icone" class="form-select">
                            <option value="">-- Aucune --</option>
                            <option value="bi-trophy-fill">🏆 Trophée</option>
                            <option value="bi-dribbble">⚽ Football</option>
                            <option value="bi-basketball">🏀 Basketball</option>
                            <option value="bi-bicycle">🚴 Cyclisme</option>
                            <option value="bi-flag-fill">🏁 Drapeau</option>
                            <option value="bi-star-fill">⭐ Étoile</option>
                            <option value="bi-lightning-fill">⚡ Éclair</option>
                            <option value="bi-megaphone-fill">📢 Mégaphone</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-lg"></i> Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
