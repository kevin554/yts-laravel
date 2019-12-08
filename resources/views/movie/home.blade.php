@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row" id="movieContainer">
                    @foreach($movieList as $movie)
                        <div class="col-sm" id="mov-{{$movie["id"]}}">
                            <a href="/movie/{{$movie["id"]}}">
                                <div class="movie">
                                    @if ($movie['poster'] != null)
                                        <img src="{{ asset('svg/'.$movie['poster']) }}" alt="movie" class="rounded img-fluid image"/>
                                    @else
                                        <img src="{{ asset('svg/play-button.svg') }}" alt="movie" class="rounded img-fluid image"/>
                                    @endif
                                    <div class="browse-movie-bottom">
                                        <p>{{ $movie["name"] }}</p>
                                        <div>{{ $movie["year"] }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <div class="col-sm" id="movieTemplate" style="display: none;">
                        <a href="/movie/{id}">
                            <div class="movie">
                                <img src="svg/play-button.svg" alt="movie" class="rounded img-fluid image"/>
                                <div class="browse-movie-bottom">
                                    <p>{name}</p>
                                    <div>{year}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" data-toggle="modal" tabindex="-1" role="dialog" data-target="#modalFormQuestion" href="">Add a movie</a>
    <div class="modal" id="modalFormQuestion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="movieForm" enctype="multipart/form-data">
                    {{--this is obligatory for security reasons--}}
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input id="name" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="year" class="col-form-label">Year:</label>
                        <input id="year" type="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="rotten_score" class="col-form-label">Rotten tomatoes score:</label>
                        <input id="rotten_score" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="imdb_score" class="col-form-label">IMDB score:</label>
                        <input id="imdb_score" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="director" class="col-form-label">Director:</label>
                        <input id="director" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Trailer:</label>
                        <input id="trailer" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Synopsis:</label>
                        <input id="synopsis" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Genres:</label>
                        <input id="genres" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <input id="btnSaveMovie" class="btn btn-primary" value="Create!">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnSaveMovie').on('click', function() {
                var params = {
                    _token: '{{csrf_token()}}',
                    name: $('#name').val(),
                    director: $('#director').val(),
                    synopsis: $('#synopsis').val(),
                    genres: $('#genres').val(),
                    // optional values
                    year: $('#year').val(),
                    rotten_score: $('#rotten_score').val(),
                    imdb_score: $('#imdb_score').val(),
                    trailer: $('#trailer').val(),
                };

                $.ajax({
                    url: '/movie/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            $('#modalFormQuestion').modal('hide');

                            var movie = data.response;

                            var col = $('<div id="mov-' + movie.id + '" class="col-sm">');
                            var movieTemplate = $('#movieTemplate').clone();

                            var html = movieTemplate.html();
                            html = html.replace('{id}', movie.id);
                            html = html.replace('{name}', movie.name);
                            html = html.replace('{year}', movie.year);

                            col.html(html);

                            $('#movieContainer').append(col);
                            $('#movieForm')[0].reset();
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            });
        });
    </script>
@endsection
