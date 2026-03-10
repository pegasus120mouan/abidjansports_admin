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
                <h3 class="card-title">Boutique - Journaux</h3>
                <div class="card-tools">
                    <a href="{{ route('journals.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Nouveau Journal
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 80px">Couverture</th>
                            <th>Titre</th>
                            <th>Numéro</th>
                            <th>Prix</th>
                            <th>Date Publication</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journals as $journal)
                        <tr>
                            <td>{{ $journal->id }}</td>
                            <td>
                                @if($journal->image_url)
                                    <img src="{{ $journal->image_url }}" alt="{{ $journal->titre }}" class="img-thumbnail" style="max-width: 60px; max-height: 80px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($journal->titre, 40) }}</td>
                            <td>{{ $journal->numero ?? '-' }}</td>
                            <td>{{ number_format($journal->prix, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $journal->date_publication->format('d/m/Y') }}</td>
                            <td>
                                @if($journal->stock > 10)
                                    <span class="badge text-bg-success">{{ $journal->stock }}</span>
                                @elseif($journal->stock > 0)
                                    <span class="badge text-bg-warning">{{ $journal->stock }}</span>
                                @else
                                    <span class="badge text-bg-danger">0</span>
                                @endif
                            </td>
                            <td>
                                @if($journal->statut === 'disponible')
                                    <span class="badge text-bg-success">Disponible</span>
                                @elseif($journal->statut === 'epuise')
                                    <span class="badge text-bg-danger">Épuisé</span>
                                @else
                                    <span class="badge text-bg-secondary">Archivé</span>
                                @endif
                            </td>
                            <td>
                                @if($journal->pdf_url)
                                    <a href="{{ $journal->pdf_url }}" class="btn btn-info btn-sm" title="Télécharger PDF" target="_blank">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                @endif
                                <a href="{{ route('journals.edit', $journal) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $journal->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Aucun journal trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $journals->links() }}
            </div>
        </div>
    </div>
</div>

@foreach($journals as $journal)
<div class="modal fade" id="deleteModal{{ $journal->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $journal->id }}" aria-hidden="true">
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
                <h4 class="mb-3">Supprimer ce journal ?</h4>
                <p class="text-muted mb-2">
                    Vous êtes sur le point de supprimer le journal :
                </p>
                <p class="fw-bold mb-4">"{{ $journal->titre }} - {{ $journal->numero }}"</p>
                <p class="text-danger small mb-4">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Cette action est irréversible.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Annuler
                    </button>
                    <form action="{{ route('journals.destroy', $journal) }}" method="POST" class="d-inline">
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
