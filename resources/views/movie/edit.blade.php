@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xs-10 col-sm-6 col-lg-5" id="movie-poster">
                <img src="{{$movie['poster'] != null ? asset('svg/'.$movie['poster']) : asset('svg/play-button.svg')}}"
                     alt="poster" class="img-responsive">
            </div>
            <div id="movie-info" class="col-lg-8">
                <h1>{{$movie["name"]}}</h1>
                <h2>{{$movie["year"]}}</h2>
                <h2>{{$movie["genres"]}}</h2>
                <p>{{$movie["imdb_score"]}}</p>
                <p>{{$movie["rotten_score"]}}</p>
            </div>

            <div id="movie-related" class="col-xs-10 col-sm-14 col-md-7 col-lg-8 col-lg-offset-1">
                <a class="" data-toggle="modal" data-target="#modalSimilar" href="">
                    <img src="{{ asset('svg/add.svg') }}" alt="add">
                </a>
                @foreach($similarsList as $similar)
                    <a href="/movie/{{$similar["other_movie_id"]}}">
                        <img src="{{ asset('svg/play-button.svg') }}" alt="poster">
                    </a>
                @endforeach
                <div id="similarTemplate" style="display: none;">
                    <a href="/movie/{id}">
                        <img src="{{asset('svg/play-button.svg')}}" alt="poster">
                    </a>
                </div>
            </div>

            <div id="movie-sub-info">
                <div id="synopsis">
                    <h3>Synopsis</h3>
                    <p>{{$movie["synopsis"]}}</p>
                </div>
                <div id="crew">
                    <h3>Director</h3>
                    <p>{{$movie["director"]}}</p>
                </div>
            </div>

            <div id="movie-specs">
                <h3>Available in</h3>
                <a class="btn quality-spec" data-toggle="modal" data-target="#modalQuality" href="">+</a>
                @foreach($qualitiesList as $quality)
                    <span class="quality-spec">{{$quality["resolution"]}}</span>
                @endforeach
                <div id="qualityTemplate" style="display: none;"><span class="quality-spec">{resolution}</span></div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="modalQuality">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="qualityForm">
                    {{--this is obligatory for security reasons--}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add a new resolucion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="movie_id" value="{{$movie["id"]}}"/>
                        <div class="form-group">
                            <labSel>Resolution:</labSel>
                            <input class="form-control" type="text" id="resolution" required="required"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="btnSaveQuality" class="btn btn-primary" value="Create!">
                        {{--<button id="btnSaveQuality" class="btn btn-primary">Add</button>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="modalSimilar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="similarForm">
                    {{--this is obligatory for security reasons--}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add a movie as a similar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="movie_id" value="{{$movie["id"]}}"/>
                        <div class="form-group">
                            <label>Movie:</label>
                            <select id="other_movie_id" class="form-control" required="required">
                                <option value="">Select a movie</option>
                                @foreach($moviesList as $eachMovie)
                                    @if($eachMovie['id'] != $movie['id'])
                                        <option value="{{$eachMovie['id']}}">{{$eachMovie['name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="btnSaveSimilar" class="btn btn-primary" value="Add it!">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnSaveQuality').on('click', function() {
                var params = {
                    _token: '{{csrf_token()}}',
                    resolution: $('#resolution').val(),
                    movie_id: $('#movie_id').val()
                };

                $.ajax({
                    url: '/quality/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            $('#modalQuality').modal('hide');

                            var quality = data.response;

                            var qualityTemplate = $('#qualityTemplate').clone();

                            var html = qualityTemplate.html();
                            html = html.replace('{resolution}', quality.resolution);

                            $('#movie-specs').append(html);
                            $('#qualityForm')[0].reset();
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            });

            $('#btnSaveSimilar').on('click', function() {
                let params = { _token: '{{csrf_token()}}', movie_id: $('#movie_id').val(), other_movie_id: $('#other_movie_id').val() };

                $.ajax({
                    url: '/similar/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            $('#modalSimilar').modal('hide');

                            var similar = data.response;

                            var similarTemplate = $('#similarTemplate').clone();

                            var html = similarTemplate.html();
                            html = html.replace('{id}', similar.other_movie_id);

                            $('#movie-related').append(html);
                            $('#similarForm')[0].reset();
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            });
        });
    </script>
@endsection
