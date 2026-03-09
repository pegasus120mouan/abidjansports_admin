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
                <h3 class="card-title">Liste des Articles 2</h3>
                <div class="card-tools">
                    <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Nouvel Article
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 80px">Image</th>
                            <th>Titre</th>
                            <th>Sous-Catégorie</th>
                            <th>Auteur</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>
                                @if($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="{{ $article->titre }}" class="img-thumbnail" style="max-width: 60px; max-height: 60px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($article->titre, 50) }}</td>
                            <td>
                                <span class="badge text-bg-primary">{{ $article->sousCategory->category->nom ?? '-' }}</span>
                                <span class="badge text-bg-secondary">{{ $article->sousCategory->nom }}</span>
                            </td>
                            <td>{{ $article->user->display_name }}</td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($article->statut === 'publie')
                                    <span class="badge text-bg-success">Publié</span>
                                @else
                                    <span class="badge text-bg-secondary">Brouillon</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('articles.preview', $article) }}" class="btn btn-info btn-sm" title="Prévisualiser">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $article->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun article trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
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
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
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