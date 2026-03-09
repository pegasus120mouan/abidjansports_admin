@extends('layout.editor')

@section('title', 'Nouvel Article')
@section('page-title', 'Rédiger un nouvel article')

@section('content')
<form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Colonne principale (gauche) -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rédiger un nouvel article</h5>
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Retour au menu
                    </a>
                </div>
                <div class="card-body">
                    <!-- Titre -->
                    <div class="mb-4">
                        <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" placeholder="Titre de l'article" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Résumé -->
                    <div class="mb-4">
                        <label for="resume" class="form-label">Résumé</label>
                        <textarea name="resume" id="resume" class="form-control @error('resume') is-invalid @enderror" rows="2" placeholder="Résumé court de l'article...">{{ old('resume') }}</textarea>
                        @error('resume')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contenu -->
                    <div class="mb-4">
                        <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                        <textarea name="contenu" id="contenu" class="summernote @error('contenu') is-invalid @enderror" required>{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" name="action" value="save" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Créer l'article
                        </button>
                        <button type="submit" name="action" value="preview" class="btn btn-info">
                            <i class="bi bi-eye"></i> Prévisualiser
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (droite) -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <!-- Catégorie -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Sélectionner --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sous-Catégorie -->
                    <div class="mb-4">
                        <label for="sous_category_id" class="form-label">Sous-Catégorie <span class="text-danger">*</span></label>
                        <select name="sous_category_id" id="sous_category_id" class="form-select @error('sous_category_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($sousCategories as $sousCategory)
                                <option value="{{ $sousCategory->id }}" data-category="{{ $sousCategory->category_id }}" {{ old('sous_category_id') == $sousCategory->id ? 'selected' : '' }}>
                                    {{ $sousCategory->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('sous_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <label class="form-label">Image</label>
                        <div id="imagePreviewContainer" class="border rounded p-3 text-center bg-light mb-2" style="min-height: 150px;">
                            <div id="imagePlaceholder" class="d-flex flex-column align-items-center justify-content-center h-100 text-muted" style="min-height: 120px;">
                                <i class="bi bi-image fs-1"></i>
                                <small>Aperçu de l'image</small>
                            </div>
                            <img src="" alt="Aperçu" id="imagePreview" class="img-fluid rounded d-none" style="max-height: 150px;">
                        </div>
                        <input type="file" name="image" id="image" class="form-control form-control-sm @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="mb-3">
                        <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                        <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
                            <option value="brouillon" {{ old('statut', 'brouillon') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                            <option value="publie" {{ old('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
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

        // Filtrer les sous-catégories par catégorie
        const categorySelect = document.getElementById('category_id');
        const sousCategorySelect = document.getElementById('sous_category_id');
        const allOptions = Array.from(sousCategorySelect.querySelectorAll('option[data-category]'));

        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;
            
            // Réinitialiser
            sousCategorySelect.innerHTML = '<option value="">-- Sélectionner --</option>';
            
            // Filtrer et ajouter les options correspondantes
            allOptions.forEach(option => {
                if (option.dataset.category === selectedCategory) {
                    sousCategorySelect.appendChild(option.cloneNode(true));
                }
            });
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
