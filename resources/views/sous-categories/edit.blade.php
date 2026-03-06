@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Modifier la Sous-Catégorie : {{ $sousCategory->nom }}</h3>
            </div>
            <form action="{{ route('sous-categories.update', $sousCategory) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner une catégorie --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $sousCategory->category_id) == $category->id ? 'selected' : '' }}>
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
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $sousCategory->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $sousCategory->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icone" class="form-label">Icône <span class="text-danger">*</span></label>
                        <select name="icone" id="icone" class="form-select @error('icone') is-invalid @enderror" required>
                            <option value="bi-trophy-fill" {{ old('icone', $sousCategory->icone) == 'bi-trophy-fill' ? 'selected' : '' }}>🏆 Trophée</option>
                            <option value="bi-dribbble" {{ old('icone', $sousCategory->icone) == 'bi-dribbble' ? 'selected' : '' }}>🏀 Basketball</option>
                            <option value="bi-stopwatch-fill" {{ old('icone', $sousCategory->icone) == 'bi-stopwatch-fill' ? 'selected' : '' }}>⏱️ Athlétisme</option>
                            <option value="bi-flag-fill" {{ old('icone', $sousCategory->icone) == 'bi-flag-fill' ? 'selected' : '' }}>🚩 Football</option>
                            <option value="bi-bicycle" {{ old('icone', $sousCategory->icone) == 'bi-bicycle' ? 'selected' : '' }}>🚴 Cyclisme</option>
                            <option value="bi-water" {{ old('icone', $sousCategory->icone) == 'bi-water' ? 'selected' : '' }}>🏊 Natation</option>
                            <option value="bi-controller" {{ old('icone', $sousCategory->icone) == 'bi-controller' ? 'selected' : '' }}>🎮 E-Sport</option>
                            <option value="bi-bullseye" {{ old('icone', $sousCategory->icone) == 'bi-bullseye' ? 'selected' : '' }}>🎯 Tir</option>
                            <option value="bi-heart-pulse-fill" {{ old('icone', $sousCategory->icone) == 'bi-heart-pulse-fill' ? 'selected' : '' }}>💪 Fitness</option>
                            <option value="bi-circle-fill" {{ old('icone', $sousCategory->icone) == 'bi-circle-fill' ? 'selected' : '' }}>● Standard</option>
                        </select>
                        @error('icone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1" {{ old('actif', $sousCategory->actif) ? 'checked' : '' }}>
                            <label for="actif" class="form-check-label">Actif</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('sous-categories.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
