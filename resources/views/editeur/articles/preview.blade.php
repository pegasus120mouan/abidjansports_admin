@extends('layout.preview-editeur')

@section('title', 'Prévisualisation - ' . $article->titre)

@section('content')
<div class="article-container">
    <!-- Image de couverture -->
    @if($article->image_url)
        <div class="position-relative">
            <img src="{{ $article->image_url }}" alt="{{ $article->titre }}" class="article-image">
            <div class="position-absolute top-0 start-0 m-3">
                <span class="category-badge">{{ $article->sousCategory->category->nom ?? 'Catégorie' }}</span>
            </div>
        </div>
    @else
        <div class="p-3">
            <span class="category-badge">{{ $article->sousCategory->category->nom ?? 'Catégorie' }}</span>
        </div>
    @endif

    <div class="p-4 p-lg-5">
        <!-- Titre -->
        <h1 class="fw-bold mb-3" style="font-size: 2.2rem; line-height: 1.3;">
            {{ $article->titre }}
        </h1>

        <!-- Métadonnées -->
        <div class="d-flex flex-wrap gap-3 text-muted mb-4 pb-4 border-bottom">
            <span>
                <i class="bi bi-person me-1"></i>
                {{ $article->user->signature ?? $article->user->prenoms . ' ' . $article->user->nom }}
            </span>
            <span>
                <i class="bi bi-calendar me-1"></i>
                {{ $article->created_at->format('d/m/Y à H:i') }}
            </span>
            <span>
                <i class="bi bi-folder me-1"></i>
                {{ $article->sousCategory->nom ?? '' }}
            </span>
        </div>

        <!-- Résumé -->
        @if($article->resume)
            <p class="lead text-muted mb-4 fst-italic">
                {{ $article->resume }}
            </p>
        @endif

        <!-- Contenu -->
        <div class="article-content">
            {!! $article->contenu !!}
        </div>

        <!-- Signature auteur -->
        <div class="mt-5 pt-4 border-top">
            <p class="fw-bold mb-0" style="color: #ff6b35;">
                {{ $article->user->signature ?? $article->user->prenoms . ' ' . $article->user->nom }}
            </p>
        </div>
    </div>
</div>
@endsection
