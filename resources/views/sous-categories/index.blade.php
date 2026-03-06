@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fs-5 py-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Liste des Sous-Catégories</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createSousCategoryModal">
                        <i class="bi bi-plus-lg"></i> Nouvelle Sous-Catégorie
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 60px">Icône</th>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sousCategories as $sousCategory)
                        <tr>
                            <td>{{ $sousCategory->id }}</td>
                            <td class="text-center"><i class="bi {{ $sousCategory->icone }} fs-5 text-primary"></i></td>
                            <td>{{ $sousCategory->nom }}</td>
                            <td><code>{{ $sousCategory->slug }}</code></td>
                            <td><span class="badge text-bg-primary">{{ $sousCategory->category->nom }}</span></td>
                            <td>
                                @if($sousCategory->actif)
                                    <span class="badge text-bg-success">Actif</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sous-categories.edit', $sousCategory) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('sous-categories.destroy', $sousCategory) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette sous-catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucune sous-catégorie trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Créer Sous-Catégorie -->
<div class="modal fade" id="createSousCategoryModal" tabindex="-1" aria-labelledby="createSousCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('sous-categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSousCategoryModalLabel">Créer une Sous-Catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icone" class="form-label">Icône <span class="text-danger">*</span></label>
                        <select name="icone" id="icone" class="form-select @error('icone') is-invalid @enderror" required>
                            <option value="bi-trophy-fill" {{ old('icone') == 'bi-trophy-fill' ? 'selected' : '' }}>🏆 Trophée</option>
                            <option value="bi-dribbble" {{ old('icone') == 'bi-dribbble' ? 'selected' : '' }}>🏀 Basketball</option>
                            <option value="bi-stopwatch-fill" {{ old('icone') == 'bi-stopwatch-fill' ? 'selected' : '' }}>⏱️ Athlétisme</option>
                            <option value="bi-flag-fill" {{ old('icone') == 'bi-flag-fill' ? 'selected' : '' }}>🚩 Football</option>
                            <option value="bi-bicycle" {{ old('icone') == 'bi-bicycle' ? 'selected' : '' }}>🚴 Cyclisme</option>
                            <option value="bi-water" {{ old('icone') == 'bi-water' ? 'selected' : '' }}>🏊 Natation</option>
                            <option value="bi-controller" {{ old('icone') == 'bi-controller' ? 'selected' : '' }}>🎮 E-Sport</option>
                            <option value="bi-bullseye" {{ old('icone') == 'bi-bullseye' ? 'selected' : '' }}>🎯 Tir</option>
                            <option value="bi-heart-pulse-fill" {{ old('icone') == 'bi-heart-pulse-fill' ? 'selected' : '' }}>💪 Fitness</option>
                            <option value="bi-circle-fill" {{ old('icone', 'bi-circle-fill') == 'bi-circle-fill' ? 'selected' : '' }}>● Standard</option>
                        </select>
                        @error('icone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1" {{ old('actif', true) ? 'checked' : '' }}>
                            <label for="actif" class="form-check-label">Actif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
