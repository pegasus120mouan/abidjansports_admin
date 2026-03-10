@extends('layout.main')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">Tableau de bord</h1>
            <p class="text-muted">Bienvenue, {{ Auth::user()->prenoms }} {{ Auth::user()->nom }}</p>
        </div>
    </div>

    {{-- Stats Cards Row 1 --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_articles'] }}</h4>
                            <span>Total Articles</span>
                        </div>
                        <i class="bi bi-newspaper fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-primary border-0">
                    <small><i class="bi bi-check-circle me-1"></i>{{ $stats['articles_publies'] }} publiés | {{ $stats['articles_brouillon'] }} brouillons</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_journaux'] }}</h4>
                            <span>Journaux (Boutique)</span>
                        </div>
                        <i class="bi bi-shop fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-success border-0">
                    <small><i class="bi bi-box me-1"></i>Stock: {{ $stats['stock_total_journaux'] }} exemplaires</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_utilisateurs'] }}</h4>
                            <span>Utilisateurs</span>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-warning border-0">
                    <small><i class="bi bi-person-badge me-1"></i>{{ $stats['total_editeurs'] }} éditeurs</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_categories'] }}</h4>
                            <span>Catégories</span>
                        </div>
                        <i class="bi bi-folder fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-info border-0">
                    <small><i class="bi bi-folder2-open me-1"></i>{{ $stats['total_sous_categories'] }} sous-catégories</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Row 2 --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-left-primary mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-primary text-uppercase small fw-bold">Aujourd'hui</div>
                            <div class="h5 mb-0 fw-bold">{{ $articlesAujourdhui }} articles</div>
                        </div>
                        <i class="bi bi-calendar-day text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-left-success mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-success text-uppercase small fw-bold">Cette semaine</div>
                            <div class="h5 mb-0 fw-bold">{{ $articlesCetteSemaine }} articles</div>
                        </div>
                        <i class="bi bi-calendar-week text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-left-warning mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-warning text-uppercase small fw-bold">Flash Infos</div>
                            <div class="h5 mb-0 fw-bold">{{ $stats['flash_actives'] }} actives</div>
                        </div>
                        <i class="bi bi-lightning text-warning fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card border-left-danger mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-danger text-uppercase small fw-bold">Journaux épuisés</div>
                            <div class="h5 mb-0 fw-bold">{{ $stats['journaux_epuises'] }}</div>
                        </div>
                        <i class="bi bi-exclamation-triangle text-danger fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-bar-chart me-1"></i>
                    Articles publiés (6 derniers mois)
                </div>
                <div class="card-body">
                    <canvas id="articlesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-pie-chart me-1"></i>
                    Articles par catégorie
                </div>
                <div class="card-body">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables Row --}}
    <div class="row">
        {{-- Derniers Articles --}}
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-newspaper me-1"></i> Derniers Articles</span>
                    <a href="{{ route('articles.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($derniersArticles as $article)
                                <tr>
                                    <td>
                                        <a href="{{ route('articles.edit', $article) }}" class="text-decoration-none">
                                            {{ Str::limit($article->titre, 30) }}
                                        </a>
                                    </td>
                                    <td><small>{{ $article->user->prenoms ?? '' }}</small></td>
                                    <td><small>{{ $article->created_at->format('d/m/Y') }}</small></td>
                                    <td>
                                        @if($article->statut === 'publie')
                                            <span class="badge bg-success">Publié</span>
                                        @else
                                            <span class="badge bg-secondary">Brouillon</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun article</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Derniers Journaux --}}
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-shop me-1"></i> Derniers Journaux</span>
                    <a href="{{ route('journals.index') }}" class="btn btn-sm btn-success">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($derniersJournaux as $journal)
                                <tr>
                                    <td>
                                        <a href="{{ route('journals.edit', $journal) }}" class="text-decoration-none">
                                            {{ Str::limit($journal->titre, 30) }}
                                        </a>
                                    </td>
                                    <td><small>{{ number_format($journal->prix, 0, ',', ' ') }} F</small></td>
                                    <td>
                                        @if($journal->stock > 10)
                                            <span class="badge bg-success">{{ $journal->stock }}</span>
                                        @elseif($journal->stock > 0)
                                            <span class="badge bg-warning">{{ $journal->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($journal->statut === 'disponible')
                                            <span class="badge bg-success">Dispo</span>
                                        @elseif($journal->statut === 'epuise')
                                            <span class="badge bg-danger">Épuisé</span>
                                        @else
                                            <span class="badge bg-secondary">Archivé</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun journal</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Utilisateurs récents --}}
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-1"></i> Derniers Utilisateurs</span>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-warning">Gérer</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Inscrit le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($derniersUtilisateurs as $user)
                                <tr>
                                    <td>{{ $user->prenoms }} {{ $user->nom }}</td>
                                    <td><small>{{ $user->email }}</small></td>
                                    <td>
                                        @if($user->role === 'administrateur')
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-info">Éditeur</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $user->created_at->format('d/m/Y H:i') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun utilisateur</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Statistiques Visiteurs --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-muted"><i class="bi bi-graph-up me-2"></i>Statistiques des Visiteurs</h4>
        </div>
    </div>

    {{-- Stats Visiteurs Cards --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-gradient border-0 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ number_format($visitesAujourdhui) }}</h3>
                            <span>Visites aujourd'hui</span>
                        </div>
                        <i class="bi bi-eye fs-1 opacity-50"></i>
                    </div>
                    <small class="opacity-75"><i class="bi bi-person me-1"></i>{{ $visiteursUniquesAujourdhui }} visiteurs uniques</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-gradient border-0 mb-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ number_format($visitesCetteSemaine) }}</h3>
                            <span>Cette semaine</span>
                        </div>
                        <i class="bi bi-calendar-week fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-gradient border-0 mb-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ number_format($visitesCeMois) }}</h3>
                            <span>Ce mois</span>
                        </div>
                        <i class="bi bi-calendar-month fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card bg-gradient border-0 mb-4" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ number_format($totalVues) }}</h3>
                            <span>Total vues articles</span>
                        </div>
                        <i class="bi bi-book fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphique Visites + Top Pays --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-graph-up me-1"></i>
                    Visites (7 derniers jours)
                </div>
                <div class="card-body">
                    <canvas id="visitesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-globe me-1"></i>
                    Top Pays Visiteurs
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topPays as $pays)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="https://flagcdn.com/16x12/{{ strtolower($pays->code_pays) }}.png" 
                                     alt="{{ $pays->pays }}" class="me-2" style="width: 20px;">
                                {{ $pays->pays }}
                            </span>
                            <span class="badge bg-primary rounded-pill">{{ number_format($pays->total) }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Aucune donnée</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Articles les plus lus --}}
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-trophy me-1"></i>
                    Articles les plus lus
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Article</th>
                                    <th>Catégorie</th>
                                    <th>Vues</th>
                                    <th>Publié le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($articlesPlusLus as $index => $article)
                                <tr>
                                    <td>
                                        @if($index < 3)
                                            <span class="badge bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'danger') }}">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('articles.edit', $article) }}" class="text-decoration-none">
                                            {{ Str::limit($article->titre, 50) }}
                                        </a>
                                    </td>
                                    <td><small>{{ $article->sousCategory->category->nom ?? '-' }}</small></td>
                                    <td><strong class="text-primary">{{ number_format($article->vues) }}</strong></td>
                                    <td><small>{{ $article->created_at->format('d/m/Y') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Aucun article avec des vues</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Articles par mois
    const articlesData = @json($articlesParMois);
    new Chart(document.getElementById('articlesChart'), {
        type: 'bar',
        data: {
            labels: articlesData.map(item => item.mois),
            datasets: [{
                label: 'Articles publiés',
                data: articlesData.map(item => item.count),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Articles par catégorie
    const categoriesData = @json($articlesParCategorie);
    const colors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(199, 199, 199, 0.7)',
        'rgba(83, 102, 255, 0.7)',
    ];
    new Chart(document.getElementById('categoriesChart'), {
        type: 'doughnut',
        data: {
            labels: categoriesData.map(item => item.nom),
            datasets: [{
                data: categoriesData.map(item => item.count),
                backgroundColor: colors.slice(0, categoriesData.length),
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Visites par jour
    const visitesData = @json($visitesParJour);
    new Chart(document.getElementById('visitesChart'), {
        type: 'line',
        data: {
            labels: visitesData.map(item => item.jour),
            datasets: [{
                label: 'Visites',
                data: visitesData.map(item => item.count),
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
.border-left-success { border-left: 4px solid #198754 !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-danger { border-left: 4px solid #dc3545 !important; }
</style>
@endsection
