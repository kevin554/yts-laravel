<?php

Route::get('/', 'MovieController@index');

Route::post('/movie/search/', 'MovieController@search');

Route::post('/movie/store', 'MovieController@store');

Route::get('/movie/{id}', 'MovieController@edit');

Route::post('/quality/store', 'QualityController@store');

Route::post('/similar/store', 'SimilarController@store');
