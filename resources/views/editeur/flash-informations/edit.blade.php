@extends('layout.editeur-dashboard')

@section('page-title', 'Modifier Flash Information')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier la flash information</h5>
    </div>
    <form action="{{ route('editeur.flash-informations.update', $flashInformation) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre', $flashInformation->titre) }}" required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="icone" class="form-label">Icône <span class="text-danger">*</span></label>
                    <select name="icone" id="icone" class="form-select @error('icone') is-invalid @enderror" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="bi-trophy-fill" {{ old('icone', $flashInformation->icone) == 'bi-trophy-fill' ? 'selected' : '' }}>🏆 Trophée</option>
                        <option value="bi-lightning-fill" {{ old('icone', $flashInformation->icone) == 'bi-lightning-fill' ? 'selected' : '' }}>⚡ Éclair</option>
                        <option value="bi-megaphone-fill" {{ old('icone', $flashInformation->icone) == 'bi-megaphone-fill' ? 'selected' : '' }}>📢 Mégaphone</option>
                        <option value="bi-bell-fill" {{ old('icone', $flashInformation->icone) == 'bi-bell-fill' ? 'selected' : '' }}>🔔 Cloche</option>
                        <option value="bi-star-fill" {{ old('icone', $flashInformation->icone) == 'bi-star-fill' ? 'selected' : '' }}>⭐ Étoile</option>
                        <option value="bi-fire" {{ old('icone', $flashInformation->icone) == 'bi-fire' ? 'selected' : '' }}>🔥 Feu</option>
                        <option value="bi-exclamation-triangle-fill" {{ old('icone', $flashInformation->icone) == 'bi-exclamation-triangle-fill' ? 'selected' : '' }}>⚠️ Alerte</option>
                        <option value="bi-info-circle-fill" {{ old('icone', $flashInformation->icone) == 'bi-info-circle-fill' ? 'selected' : '' }}>ℹ️ Info</option>
                    </select>
                    @error('icone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                <textarea name="contenu" id="contenu" class="form-control @error('contenu') is-invalid @enderror" rows="4" required>{{ old('contenu', $flashInformation->contenu) }}</textarea>
                @error('contenu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('editeur.flash-informations.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
