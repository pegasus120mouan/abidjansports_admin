@extends('layout.editeur-dashboard')

@section('page-title', 'Tableau de bord')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['articles'] }}</h3>
                        <p class="mb-0">Mes Articles</p>
                    </div>
                    <i class="bi bi-file-earmark-text fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-primary border-0">
                <small>{{ $stats['articles_publies'] }} publiés · {{ $stats['articles_brouillon'] }} brouillons</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['categories'] }}</h3>
                        <p class="mb-0">Catégories</p>
                    </div>
                    <i class="bi bi-folder fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['flash_informations'] }}</h3>
                        <p class="mb-0">Flash Infos</p>
                    </div>
                    <i class="bi bi-lightning fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Mes derniers articles</h5>
        <a href="{{ route('editeur.articles.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nouvel Article
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($derniers_articles as $article)
                    <tr>
                        <td>{{ Str::limit($article->titre, 40) }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $article->sousCategory->category->nom ?? '-' }}</span>
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
                            <a href="{{ route('editeur.articles.edit', $article) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Aucun article pour le moment
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
