<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>FAQ Me</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="https://www.google.com/recaptcha/api.js"> </script>
    </head>
    <body>
        <nav class="navbar navbar-toggleable-sm navbar-light bg-faded sticky-top">
            <button class="navbar-toggler navbar-toggler-right"
                type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/">FAQ Me</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#inDevModal" href="#">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link inDevModal" data-toggle="modal" data-target="#inDevModal" href="#">By us a beer</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#inDevModal" href="#">About</a>
                    </li>
                </ul>
            </div>
        </nav>

         <div class="container">
            @if (session("status"))
                <div class="alert alert-info" data-dismiss="alert">
                    {!! session("status") !!}
                </div>
            @endif
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

        <nav class="navbar navbar-light bg-faded text-center fixed-bottom">
            <a class="navbar-brand" href="https://github.com/ice-blaze/faq"><i class="fa fa-github fa-1x"></i></a>
        </nav>

        <div class="modal fade" id="inDevModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h3 class="modal-title" id="exampleModalLabel">In dev</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- scripts -->
        <script type="text/javascript" src="{{ mix('js/basic.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

        @yield('afterScript')
    </body>
</html>
