<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Series;

class SeriesController extends Controller
{

    public function index(){
        $series = Series::all();
        return response()->json(['series' => $series], 200);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'release_year' => 'required|digits:4|integer',
        ]);

        $series = Series::create($validated);

        return response()->json(['series' => $series], 201);
    }


    public function show($id){
        $series = Series::find($id);

        if (!$series) {
            return response()->json(['message' => 'Error'], 404);
        }

        return response()->json(['series' => $series], 200);
    }


    public function update(Request $request, $id){
        $series = Series::find($id);

        if (!$series) {
            return response()->json(['message' => 'Error'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:100',
            'release_year' => 'sometimes|digits:4|integer',
        ]);

        $series->update($validated);

        return response()->json(['series' => $series], 200);
    }


    public function destroy($id){
        $series = Series::find($id);

        if (!$series) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        $series->delete();

        return response()->json(['message' => 'Series deleted'], 200);
    }
}
