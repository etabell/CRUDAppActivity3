@extends('layouts.app')

@section('content')
<div class="container p-4 bg-secondary shadow rounded">
    <h1 class="text-center text-warning mb-4">
        <i class="fas fa-film"></i> Movie Collection Tracker
    </h1>

    <!-- Search Bar -->
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" id="searchBar" class="form-control" placeholder="Search by title, director, or genre...">
    </div>

    <!-- Add Movie Button -->
    <div class="mb-3">
        <a href="{{ route('movies.create') }}" class="btn btn-success add-movie-btn w-100">
            <i class="fas fa-plus"></i> Add New Movie
        </a>
    </div>

    <!-- Movie Table -->
    <table class="table table-dark table-striped table-bordered mt-4">
        <thead class="table-warning text-dark">
            <tr>
                <th>Title</th>
                <th>Director</th>
                <th>Genre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="movieList">
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->director }}</td>
                    <td>{{ $movie->genre }}</td>
                    <td>
                        <a href="{{ route('movies.edit', $movie) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('movies.destroy', $movie) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete {{ $movie->title }}?');">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Clear All Button -->
    <form action="{{ route('movies.clear') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger w-100" 
                onclick="return confirm('Are you sure you want to delete all movies?');">
            <i class="fas fa-trash"></i> Clear All Movies
        </button>
    </form>
</div>

<!-- Logout Button (only on index) -->
<form action="{{ route('logout') }}" method="POST" class="position-fixed bottom-0 end-0 m-3">
    @csrf
    <button type="submit" class="btn btn-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
    </button>
</form>

@push('scripts')
<script>
    // Store movies data from PHP
    const movies = @json($movies);

    // Search functionality
    const searchBar = document.getElementById('searchBar');
    const movieList = document.getElementById('movieList');

    // Function to highlight matching text
    function highlightText(text, query) {
        if (!query) return text;
        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        return text.replace(regex, '<span class="highlight">$1</span>');
    }

    // Handle search filtering and highlighting
    searchBar.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const filteredMovies = movies.filter(movie => 
            movie.title.toLowerCase().includes(query) ||
            movie.director.toLowerCase().includes(query) ||
            movie.genre.toLowerCase().includes(query)
        );

        // Render filtered movies with highlighted text
        movieList.innerHTML = filteredMovies.map(movie => `
            <tr>
                <td>${highlightText(movie.title, query)}</td>
                <td>${highlightText(movie.director, query)}</td>
                <td>${highlightText(movie.genre, query)}</td>
                <td>
                    <a href="/movies/${movie.id}/edit" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="/movies/${movie.id}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure you want to delete ${movie.title}?');">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        `).join('');
    });

    // Display flash messages
    @if(session('message'))
        alert("{{ session('message') }}");
    @endif
</script>
@endpush
@endsection