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
                <h3 class="card-title">Liste des Flash Informations</h3>
                <div class="card-tools">
                    <a href="{{ route('flash-informations.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Nouvelle Flash Info
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 60px">Icône</th>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Auteur</th>
                            <th>Statut</th>
                            <th style="width: 180px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($flashInfos as $flash)
                        <tr>
                            <td>{{ $flash->id }}</td>
                            <td class="text-center"><i class="bi {{ $flash->icone }} fs-5 text-warning"></i></td>
                            <td>{{ Str::limit($flash->titre, 40) }}</td>
                            <td>{{ Str::limit($flash->contenu, 50) }}</td>
                            <td>{{ $flash->user->prenoms }} {{ $flash->user->nom }}</td>
                            <td>
                                <form action="{{ route('flash-informations.toggle', $flash) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($flash->actif)
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Actif
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-x-circle"></i> Inactif
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('flash-informations.edit', $flash) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('flash-informations.destroy', $flash) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette flash info ?')">
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
                            <td colspan="7" class="text-center">Aucune flash information trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $flashInfos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
