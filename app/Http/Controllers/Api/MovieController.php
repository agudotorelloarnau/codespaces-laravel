<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{

    public function index(){
        $movies = Movie::all();
        return response()->json(['movies' => $movies], 200);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'series_id' => 'required|exists:series,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'release_year' => 'required|digits:4|integer',
        ]);

        $movie = Movie::create($validated);
        return response()->json(['movie' => $movie], 201);
    }


    public function show($id){
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Error'], 404);
        }

        return response()->json(['movie' => $movie], 200);
    }


    public function update(Request $request, $id){
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Error'], 404);
        }

        $validated = $request->validate([
            'series_id' => 'sometimes|exists:series,id',
            'title' => 'sometimes|string|max:255',
            'duration' => 'sometimes|integer|min:1',
            'release_year' => 'sometimes|digits:4|integer',
        ]);

        $movie->update($validated);
        return response()->json(['movie' => $movie], 200);
    }

    public function destroy($id){
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Error'], 404);
        }
        $movie->delete();
        return response()->json(['message' => 'Pelicula eliminada'], 200);
    }
}
