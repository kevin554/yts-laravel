<?php

namespace App\Http\Controllers;

use App\Similar;
use Illuminate\Http\Request;

class SimilarController extends Controller
{

    public function store(Request $request) {
        $similar = new Similar();
        $similar->movie_id = $request->get('movie_id');
        $similar->other_movie_id = $request->get('other_movie_id');
        $similar->save();

        $response = [
            'success' => true,
            'response' => $similar,
            'message' => 'Similar added!'
        ];

        return json_encode($response);
    }
}
