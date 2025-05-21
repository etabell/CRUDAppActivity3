<?php

   namespace App\Http\Controllers;

   use App\Models\Movie;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;

   class MovieController extends Controller
   {
       public function index(Request $request)
       {
           $query = $request->input('search');
           $movies = Movie::when($query, function ($queryBuilder) use ($query) {
               return $queryBuilder->where('title', 'like', "%{$query}%")
                   ->orWhere('director', 'like', "%{$query}%")
                   ->orWhere('genre', 'like', "%{$query}%");
           })->get();

           return view('movies.index', compact('movies', 'query'));
       }

       public function create()
       {
           return view('movies.create');
       }

       public function store(Request $request)
       {
           $request->validate([
               'title' => 'required',
               'director' => 'required',
               'genre' => 'required'
           ]);

           Movie::create($request->all());

           return redirect()->route('movies.index')
               ->with('success', 'Movie added successfully!');
       }

       public function edit(Movie $movie)
       {
           return view('movies.edit', compact('movie'));
       }

       public function update(Request $request, Movie $movie)
       {
           $request->validate([
               'title' => 'required',
               'director' => 'required',
               'genre' => 'required'
           ]);

           $movie->update($request->all());

           return redirect()->route('movies.index')
               ->with('success', 'Movie updated successfully!');
       }

       public function destroy(Movie $movie)
       {
           $movie->delete();

           return redirect()->route('movies.index')
               ->with('success', 'Movie deleted successfully!');
       }

       public function clear()
       {
           Movie::truncate();

           return redirect()->route('movies.index')
               ->with('success', 'All movies cleared successfully!');
       }
   }
   