@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-secondary shadow rounded p-4">
                <h2 class="text-center text-warning">
                    <i class="fas fa-edit"></i> Edit Movie
                </h2>
                <form id="movieForm" method="POST" action="{{ route('movies.update', $movie) }}" class="row g-2">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label"><i class="fas fa-film"></i> Movie Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $movie->title) }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="director" class="form-label"><i class="fas fa-user"></i> Director</label>
                        <input type="text" name="director" id="director" class="form-control @error('director') is-invalid @enderror" value="{{ old('director', $movie->director) }}" required>
                        @error('director')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="genre" class="form-label"><i class="fas fa-tags"></i> Genre</label>
                        <input type="text" name="genre" id="genre" class="form-control @error('genre') is-invalid @enderror" value="{{ old('genre', $movie->genre) }}" required>
                        @error('genre')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex flex-column gap-2" id="buttonContainer">
                            <button type="submit" id="editBtn" class="btn btn-warning">
                                <i class="fas fa-check"></i> Update Movie
                            </button>
                            <a href="{{ route('movies.index') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-arrow-left"></i> Back to Movie List
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <script>alert("{{ session('success') }}");</script>
@endif
@if(session('error'))
    <script>alert("{{ session('error') }}");</script>
@endif
@endsection