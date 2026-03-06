@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Modifier la Catégorie : {{ $category->nom }}</h3>
            </div>
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $category->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Catégorie Parente</label>
                        <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">-- Aucune (catégorie principale) --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                    @for($i = 0; $i < $cat->depth; $i++)—@endfor
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1" {{ old('actif', $category->actif) ? 'checked' : '' }}>
                            <label for="actif" class="form-check-label">Actif</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
