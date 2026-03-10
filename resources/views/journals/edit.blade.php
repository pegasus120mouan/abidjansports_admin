@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Modifier le Journal</h3>
                <div class="card-tools">
                    <a href="{{ route('journals.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
            <form action="{{ route('journals.update', $journal) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $journal->titre) }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="numero" class="form-label">Numéro</label>
                                        <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $journal->numero) }}" placeholder="Ex: N°245">
                                        @error('numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date_publication" class="form-label">Date de Publication <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('date_publication') is-invalid @enderror" id="date_publication" name="date_publication" value="{{ old('date_publication', $journal->date_publication->format('Y-m-d')) }}" required>
                                        @error('date_publication')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $journal->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="prix" class="form-label">Prix (FCFA) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $journal->prix) }}" min="0" step="50" required>
                                        @error('prix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $journal->stock) }}" min="0" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                                        <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                                            <option value="disponible" {{ old('statut', $journal->statut) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                            <option value="epuise" {{ old('statut', $journal->statut) == 'epuise' ? 'selected' : '' }}>Épuisé</option>
                                            <option value="archive" {{ old('statut', $journal->statut) == 'archive' ? 'selected' : '' }}>Archivé</option>
                                        </select>
                                        @error('statut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="image" class="form-label">Image de Couverture</label>
                                @if($journal->image_url)
                                    <div class="mb-2">
                                        <img src="{{ $journal->image_url }}" alt="{{ $journal->titre }}" class="img-thumbnail" style="max-width: 200px;">
                                        <p class="small text-muted mt-1">Image actuelle</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <small class="text-muted">Formats: JPEG, PNG, JPG, WEBP. Max: 2MB</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="imagePreview" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="fichier_pdf" class="form-label">Fichier PDF</label>
                                @if($journal->pdf_url)
                                    <div class="mb-2">
                                        <a href="{{ $journal->pdf_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-file-pdf me-1"></i> Voir le PDF actuel
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('fichier_pdf') is-invalid @enderror" id="fichier_pdf" name="fichier_pdf" accept=".pdf">
                                <small class="text-muted">Format: PDF. Max: 10MB</small>
                                @error('fichier_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Mettre à jour
                    </button>
                    <a href="{{ route('journals.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg me-1"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxWidth = '200px';
            preview.appendChild(img);
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endsection
