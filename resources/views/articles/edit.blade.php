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
                <div class="mb-3">
                    <div id="imagePreviewContainer" class="border rounded p-2 text-center bg-light" style="min-height: 150px;">
                        @if($article->image_url)
                            <img src="{{ $article->image_url }}" alt="Image actuelle" id="imagePreview" class="img-fluid rounded" style="max-height: 200px;">
                        @else
                            <div id="imagePlaceholder" class="d-flex flex-column align-items-center justify-content-center h-100 text-muted" style="min-height: 150px;">
                                <i class="bi bi-image fs-1"></i>
                                <span>Aperçu de l'image</span>
                            </div>
                            <img src="" alt="Aperçu" id="imagePreview" class="img-fluid rounded d-none" style="max-height: 200px;">
                        @endif
                    </div>
                </div>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
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

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('imagePlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
