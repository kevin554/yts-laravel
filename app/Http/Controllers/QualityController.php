<?php

namespace App\Http\Controllers;

use App\Quality;
use Illuminate\Http\Request;

class QualityController extends Controller
{

    public function store(Request $request) {
        $quality = new Quality();
        $quality->resolution = $request->get('resolution');
        $quality->movie_id = $request->get('movie_id');
        $quality->save();

        $response = [
            'success' => true,
            'response' => $quality,
            'message' => 'Quality created!'
        ];

        return json_encode($response);
    }
}
