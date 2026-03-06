@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Modifier la Flash Information</h3>
            </div>
            <form action="{{ route('flash-informations.update', $flashInformation) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre', $flashInformation->titre) }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                        <textarea name="contenu" id="contenu" class="form-control @error('contenu') is-invalid @enderror" rows="4" required>{{ old('contenu', $flashInformation->contenu) }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icone" class="form-label">Icône <span class="text-danger">*</span></label>
                        <select name="icone" id="icone" class="form-select @error('icone') is-invalid @enderror" required>
                            <option value="bi-trophy-fill" {{ old('icone', $flashInformation->icone) == 'bi-trophy-fill' ? 'selected' : '' }}>🏆 Trophée (Classement)</option>
                            <option value="bi-dribbble" {{ old('icone', $flashInformation->icone) == 'bi-dribbble' ? 'selected' : '' }}>🏀 Basketball</option>
                            <option value="bi-stopwatch-fill" {{ old('icone', $flashInformation->icone) == 'bi-stopwatch-fill' ? 'selected' : '' }}>⏱️ Athlétisme</option>
                            <option value="bi-flag-fill" {{ old('icone', $flashInformation->icone) == 'bi-flag-fill' ? 'selected' : '' }}>🚩 CAN / Compétition</option>
                            <option value="bi-star-fill" {{ old('icone', $flashInformation->icone) == 'bi-star-fill' ? 'selected' : '' }}>⭐ Ligue 1</option>
                            <option value="bi-lightning-fill" {{ old('icone', $flashInformation->icone) == 'bi-lightning-fill' ? 'selected' : '' }}>⚡ Flash / Urgent</option>
                            <option value="bi-megaphone-fill" {{ old('icone', $flashInformation->icone) == 'bi-megaphone-fill' ? 'selected' : '' }}>📢 Annonce</option>
                            <option value="bi-calendar-event-fill" {{ old('icone', $flashInformation->icone) == 'bi-calendar-event-fill' ? 'selected' : '' }}>📅 Événement</option>
                            <option value="bi-person-fill" {{ old('icone', $flashInformation->icone) == 'bi-person-fill' ? 'selected' : '' }}>👤 Joueur</option>
                            <option value="bi-circle-fill" {{ old('icone', $flashInformation->icone) == 'bi-circle-fill' ? 'selected' : '' }}>● Standard</option>
                        </select>
                        @error('icone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="actif" id="actif" value="1" {{ old('actif', $flashInformation->actif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="actif">Actif</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('flash-informations.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
