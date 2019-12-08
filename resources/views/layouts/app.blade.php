<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YTS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body {
            background-color: #1d1d1d;
            color: white;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .modal {
            color: black;
        }

        .navbar {
            background: #1d1d1d;
            border-bottom: 1px solid #2f2f2f;
            color: #919191;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('svg/logo-YTS.svg')}}" alt="">
                </a>

                <span class="header-slogan">
                    HD movies at the smallest file size.
                </span>

                <button class="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse"
                     id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <form class="form-inline w-100 order-2">
                            <div class="input-group w-100">
                                <input type="search" class="form-control quick-search" placeholder="quick search" aria-label="Search" aria-describedby="basic-addon1">
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.quick-search').keypress(function (e) {
                if (e.which == 13) {
                    var params = {
                        _token: '{{csrf_token()}}',
                        value: $('.quick-search').val(),
                    };

                    $.ajax({
                        url: '/movie/search',
                        method: 'POST',
                        data: params,
                        success: function(data) {
                            data = JSON.parse(data);

                            if (data.success) {
                                var moviesList = data.response;

                                var movieTemplate = $('#movieTemplate').clone();
                                $('#movieContainer').html('');

                                jQuery.each(moviesList, function (i, movie) {
                                    var col = $('<div id="mov-' + movie.id + '" class="col-sm">');
                                    var eachTemplate = movieTemplate.clone();
                                    var html = eachTemplate.html();

                                    html = html.replace('{id}', movie.id);
                                    html = html.replace('{name}', movie.name);
                                    html = html.replace('{year}', movie.year);

                                    if (movie.poster != null) {
                                        html = html.replace('{poster}', movie.poster);
                                    } else {
                                        html = html.replace('{poster}', 'play-button.svg');
                                    }

                                    col.html(html);
                                    $('#movieContainer').append(col);
                                });
                            }
                        }, error(e) {
                            console.log(e);
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</body>
</html>
