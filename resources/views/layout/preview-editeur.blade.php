<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Prévisualisation')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .preview-header {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .article-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .article-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
        }
        .article-content {
            font-size: 1.1rem;
            line-height: 1.9;
        }
        .article-content p {
            margin-bottom: 1.5rem;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .category-badge {
            background-color: #ff6b35;
            color: white;
            padding: 0.5rem 1rem;
            font-weight: 600;
            display: inline-block;
        }
        .preview-footer {
            background-color: #333;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header de prévisualisation -->
    <header class="preview-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-eye me-2"></i>
                    <strong>Mode Prévisualisation</strong>
                    <span class="ms-2 badge bg-warning text-dark">Brouillon</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('editeur.articles.edit', $article) }}" class="btn btn-light btn-sm">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    @if($article->statut === 'brouillon')
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#publishModal">
                            <i class="bi bi-check-circle"></i> Publier
                        </button>
                    @else
                        <span class="badge bg-success align-self-center py-2">Déjà publié</span>
                    @endif
                    <a href="{{ route('editeur.articles.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-x-lg"></i> Fermer
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu de l'article -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer simple -->
    <footer class="preview-footer">
        <div class="container">
            <p class="mb-0">
                <strong>Abidjan Sports</strong> - Prévisualisation de l'article
            </p>
        </div>
    </footer>

    <!-- Modal de confirmation de publication -->
    @if($article->statut === 'brouillon')
    <div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="publishModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center px-4 pb-4">
                    <div class="mb-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-check-circle text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Publier cet article ?</h4>
                    <p class="text-muted mb-4">
                        L'article <strong>"{{ Str::limit($article->titre, 50) }}"</strong> sera visible par tous les visiteurs du site.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </button>
                        <form action="{{ route('editeur.articles.publish', $article) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-lg me-1"></i> Oui, publier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
