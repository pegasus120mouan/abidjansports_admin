@extends('layout.editor')

@section('title', 'Modifier l\'article')
@section('page-title', 'Modifier l\'article')

@section('content')
<form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" id="titre" class="form-control form-control-lg @error('titre') is-invalid @enderror" value="{{ old('titre', $article->titre) }}" placeholder="Titre de l'article" required>
                @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="sous_category_id" class="form-label">Sous-Catégorie <span class="text-danger">*</span></label>
                <select name="sous_category_id" id="sous_category_id" class="form-select form-select-lg @error('sous_category_id') is-invalid @enderror" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($sousCategories as $sousCategory)
                        <option value="{{ $sousCategory->id }}" {{ old('sous_category_id', $article->sous_category_id) == $sousCategory->id ? 'selected' : '' }}>
                            {{ $sousCategory->category->nom }} > {{ $sousCategory->nom }}
                        </option>
                    @endforeach
                </select>
                @error('sous_category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-4">
        <label for="resume" class="form-label">Résumé</label>
        <textarea name="resume" id="resume" class="form-control @error('resume') is-invalid @enderror" rows="2" placeholder="Résumé court de l'article...">{{ old('resume', $article->resume) }}</textarea>
        @error('resume')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
        <textarea name="contenu" id="contenu" class="summernote @error('contenu') is-invalid @enderror" required>{{ old('contenu', $article->contenu) }}</textarea>
        @error('contenu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                @if($article->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" class="img-thumbnail" style="max-height: 100px;">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
                    <option value="brouillon" {{ old('statut', $article->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="publie" {{ old('statut', $article->statut) == 'publie' ? 'selected' : '' }}>Publié</option>
                </select>
                @error('statut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Enregistrer les modifications
        </button>
    </div>
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            lang: 'fr-FR',
            height: 400,
            placeholder: 'Rédigez votre article ici...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
@endsection
