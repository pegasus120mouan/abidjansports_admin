@extends('layout.editeur-dashboard')

@section('page-title', 'Mes Articles')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste de mes articles</h5>
        <a href="{{ route('editeur.articles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvel Article
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px">Image</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th style="width: 120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                    <tr>
                        <td>
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->titre }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ Str::limit($article->titre, 50) }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $article->sousCategory->category->nom ?? '-' }}</span>
                            <span class="badge bg-secondary">{{ $article->sousCategory->nom ?? '-' }}</span>
                        </td>
                        <td>
                            @if($article->statut === 'publie')
                                <span class="badge bg-success">Publié</span>
                            @else
                                <span class="badge bg-warning text-dark">Brouillon</span>
                            @endif
                        </td>
                        <td>{{ $article->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('editeur.articles.preview', $article) }}" class="btn btn-sm btn-info" title="Prévisualiser">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('editeur.articles.edit', $article) }}" class="btn btn-sm btn-warning" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $article->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Aucun article pour le moment
                            <br>
                            <a href="{{ route('editeur.articles.create') }}" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-lg"></i> Créer mon premier article
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($articles->hasPages())
    <div class="card-footer">
        {{ $articles->links() }}
    </div>
    @endif
</div>

<!-- Modals de suppression -->
@foreach($articles as $article)
<div class="modal fade" id="deleteModal{{ $article->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $article->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <div class="mb-4">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-trash text-danger" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h4 class="mb-3">Supprimer cet article ?</h4>
                <p class="text-muted mb-2">
                    Vous êtes sur le point de supprimer l'article :
                </p>
                <p class="fw-bold mb-4">"{{ Str::limit($article->titre, 60) }}"</p>
                <p class="text-danger small mb-4">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Cette action est irréversible.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Annuler
                    </button>
                    <form action="{{ route('editeur.articles.destroy', $article) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-trash me-1"></i> Oui, supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
