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
                <h3 class="card-title">Liste des Catégories</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="bi bi-plus-lg"></i> Nouvelle Catégorie
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Statut</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allCategories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                @for($i = 0; $i < $category->depth; $i++)
                                    <span class="text-muted">—</span>
                                @endfor
                                {{ $category->nom }}
                            </td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                @if($category->actif)
                                    <span class="badge text-bg-success">Actif</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal{{ $category->id }}" title="Ajouter sous-catégorie">
                                    <i class="bi bi-plus"></i>
                                </button>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Les sous-catégories seront également supprimées.')">
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
                            <td colspan="5" class="text-center">Aucune catégorie trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Créer Catégorie -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Créer une Catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1" {{ old('actif', true) ? 'checked' : '' }}>
                            <label for="actif" class="form-check-label">Actif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($allCategories as $category)
<!-- Modal Ajouter Sous-Catégorie pour {{ $category->nom }} -->
<div class="modal fade" id="addSubCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="addSubCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $category->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubCategoryModalLabel{{ $category->id }}">Ajouter une sous-catégorie à "{{ $category->nom }}"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom{{ $category->id }}" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom{{ $category->id }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description{{ $category->id }}" class="form-label">Description</label>
                        <textarea name="description" id="description{{ $category->id }}" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="actif" id="actif{{ $category->id }}" class="form-check-input" value="1" checked>
                            <label for="actif{{ $category->id }}" class="form-check-label">Actif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
