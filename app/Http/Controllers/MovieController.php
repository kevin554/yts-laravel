<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;
use Validator;

class MovieController extends Controller
{

    public function index() {
        $movieList = Movie::all();
        return view('movie.home', compact('movieList'));
    }

    public function store(Request $request) {
        $movie = new Movie();

        // TODO add the trailer and the poster
        $movie->name = $request->get('name');
        $movie->year = $request->get('year') ? $request->get('year') : '';
        $movie->rotten_score = $request->get('rotten_score') ? $request->get('rotten_score') : '';
        $movie->imdb_score = $request->get('imdb_score') ? $request->get('imdb_score') : '';
        $movie->director = $request->get('director');
        $movie->trailer = $request->get('trailer') ? $request->get('trailer') : '';
        $movie->synopsis = $request->get('synopsis');
        $movie->genres = $request->get('genres');
        $movie->save();

        $response = [
            'success' => true,
            'response' => $movie,
            'message' => 'Movie created!'
        ];

        return json_encode($response);
    }

    public function edit($id) {
        $movie = Movie::find($id);
        $moviesList = Movie::all();
        $qualitiesList = $movie->qualities;
        $similarsList = $movie->similars;

        return view('movie.edit', compact('movie', 'moviesList', 'qualitiesList', 'similarsList'));
    }

    public function search(Request $request) {
        // TODO case insensitive search
        $q = $request->get('value');
        $moviesList = Movie::where('name', 'like', '%'.$q.'%')->get();

        $response = [
            'success' => true,
            'response' => $moviesList,
            'message' => 'Movies'
        ];

        return json_encode($response);
    }
}
