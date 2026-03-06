<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rédaction') - AbidjanSports Admin</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f6f9;
        }
        .editor-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .editor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .editor-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .note-editor {
            border: 1px solid #dee2e6 !important;
        }
        .note-editor .note-toolbar {
            background-color: #f8f9fa;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="editor-container">
        <div class="editor-header">
            <h4 class="mb-0">@yield('page-title', 'Rédaction d\'article')</h4>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour au menu
            </a>
        </div>

        <div class="editor-card">
            @yield('content')
        </div>
    </div>

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
