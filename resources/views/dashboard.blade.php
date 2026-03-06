@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bienvenue, {{ Auth::user()->name }}</h3>
                </div>
                <div class="card-body">
                    <p>Vous êtes connecté au tableau de bord.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
