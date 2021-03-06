<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>FAQ Me</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
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
            <div class="row">
                <div class="col text-center">
                    <h1 class="display-1">FAQ Me</h1>
                    <p class="lead">FAQ Description</p>
                </div>
            </div>
            <div class="row">
                <form method="post" action="@yield('action')">
                {{ csrf_field() }}
                <div class="col-lg-4 offset-lg-2 col-md-6">
                    <label for="question"><b>Question</b></label>
                    <textarea type="text" class="form-control" id="question"
                        aria-describedby="question" placeholder="Write the question"></textarea>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="answer"><b>Answer</b></label>
                    <textarea class="form-control" id="answer"
                        aria-describedby="answer" placeholder="Anser the question"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <br/>
                    <button type="submit" class="btn btn-primary">Add Question</button>
                    <br/>
                    <br/>
                    </form>
                </div>
            </div>
            @forelse($qas as $qa)
                <div class="row">
                    <div class="col-lg-10 offset-lg-2 col-md-8 ">
                        <b>Q: What do you think.... ?</b>
                        <p class="lead">A: It's not eay to ....</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <b>Q: What do you think.... ?</b>
                        <p class="lead">A: It's not eay to ....</p>
                    </div>
                </div>
            @empty
                <div class="row">
                    <div class="col text-center">
                        <p class="lead">No comments yet</p>
                    </div>
                </div>
            @endforelse
        </div>

        <nav class="navbar fixed-bottom navbar-light bg-faded text-center">
            <a class="navbar-brand" href="https://github.com/ice-blaze/faq">GitHub</a>
        </nav>

        <!-- scripts -->
        <script
            src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
            integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
            integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
            integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
