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
                            <a href="{{ route('editeur.articles.edit', $article) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('editeur.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet article ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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
@endsection
