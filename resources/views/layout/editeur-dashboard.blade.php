<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>AbidjanSports - Espace Éditeur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 60px;
            --primary-color: #0d6efd;
            --sidebar-bg: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-active: #3b82f6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h4 {
            color: #fff;
            margin: 0;
            font-size: 1.2rem;
        }
        
        .sidebar-header small {
            color: var(--sidebar-text);
        }
        
        .sidebar-nav {
            padding: 15px 0;
        }
        
        .nav-section {
            padding: 10px 20px 5px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }
        
        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }
        
        .sidebar-nav .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .top-header {
            background: #fff;
            height: var(--header-height);
            padding: 0 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .page-content {
            padding: 25px;
        }
        
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 20px;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-newspaper me-2"></i>AbidjanSports</h4>
            <small>Espace Éditeur</small>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">Menu Principal</div>
            
            <a href="{{ route('editeur.dashboard') }}" class="nav-link {{ request()->routeIs('editeur.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                Tableau de bord
            </a>
            
            <div class="nav-section">Contenu</div>
            
            <a href="{{ route('editeur.articles.index') }}" class="nav-link {{ request()->routeIs('editeur.articles.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                Mes Articles
            </a>
            
            <a href="{{ route('editeur.categories.index') }}" class="nav-link {{ request()->routeIs('editeur.categories.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i>
                Catégories
            </a>
            
            <a href="{{ route('editeur.flash-informations.index') }}" class="nav-link {{ request()->routeIs('editeur.flash-informations.*') ? 'active' : '' }}">
                <i class="bi bi-lightning"></i>
                Flash Informations
            </a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <h5 class="mb-0">@yield('page-title', 'Tableau de bord')</h5>
            
            <div class="dropdown">
                <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <div class="user-dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->prenoms, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                        </div>
                        <span>{{ auth()->user()->prenoms }} {{ auth()->user()->nom }}</span>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Mon Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-fr-FR.min.js"></script>
    
    @stack('scripts')
</body>
</html>
