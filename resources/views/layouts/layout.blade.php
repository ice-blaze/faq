<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>FAQ Me</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    </head>
    <body>
        <nav class="navbar navbar-toggleable-sm navbar-light bg-faded">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">FAQ Me</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">By us a beer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
            </div>
        </nav>

         <div class="container">
            @if (count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" data-dismiss="alert">
                        {{ $error  }}
                    </div>
                @endforeach
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" data-dismiss="alert">
                    {{ Session::get('error')  }}
                </div>
            @endif
        </div>

        @yield('content')

        <nav class="navbar fixed-bottom navbar-light bg-faded text-center">
            <a class="navbar-brand" href="https://github.com/ice-blaze/faq">GitHub</a>
        </nav>

        <!-- scripts -->
        <script type="text/javascript" src="{{ mix('js/basic.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

        @yield('afterScript')
    </body>
</html>
