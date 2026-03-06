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
                            <td>{{ $article->user->prenoms }} {{ $article->user->nom }}</td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($article->statut === 'publie')
                                    <span class="badge text-bg-success">Publié</span>
                                @else
                                    <span class="badge text-bg-secondary">Brouillon</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
@endsection