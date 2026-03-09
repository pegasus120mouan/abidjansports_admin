@extends('layout.editeur-dashboard')

@section('page-title', 'Flash Informations')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Mes Flash Informations</h5>
        <a href="{{ route('editeur.flash-informations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvelle Flash Info
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px">Icône</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flashInformations as $flash)
                    <tr>
                        <td class="text-center">
                            <i class="bi {{ $flash->icone }} fs-4 text-primary"></i>
                        </td>
                        <td>{{ $flash->titre }}</td>
                        <td>{{ Str::limit($flash->contenu, 50) }}</td>
                        <td>
                            @if($flash->actif)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>{{ $flash->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('editeur.flash-informations.toggle', $flash) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $flash->actif ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $flash->actif ? 'Désactiver' : 'Activer' }}">
                                    <i class="bi {{ $flash->actif ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                </button>
                            </form>
                            <a href="{{ route('editeur.flash-informations.edit', $flash) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('editeur.flash-informations.destroy', $flash) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette flash info ?')">
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
                            <i class="bi bi-lightning fs-1 d-block mb-2"></i>
                            Aucune flash information
                            <br>
                            <a href="{{ route('editeur.flash-informations.create') }}" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-lg"></i> Créer ma première flash info
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($flashInformations->hasPages())
    <div class="card-footer">
        {{ $flashInformations->links() }}
    </div>
    @endif
</div>
@endsection
