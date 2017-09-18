@extends('layouts.layout')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col text-center">
                <h1 class="display-1">FAQ Me</h1>
                <p class="lead">FAQ Description</p>
            </div>
        </div>
        @if($isOkay)
            <form method="post" action="/{{$faq->id}}/{{$faq->admin_code}}/qas/create">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-4 offset-lg-2 col-md-6">
                        <label for="question"><b>Question</b></label>
                        <textarea type="text" class="form-control" name="question"
                            aria-describedby="question" placeholder="Write the question"></textarea>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label for="answer"><b>Answer</b></label>
                        <textarea class="form-control" name="answer"
                            aria-describedby="answer" placeholder="Anser the question"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <br/>
                        <button type="submit" class="btn btn-primary">Add Question</button>
                        <br/>
                        <br/>
                    </div>
                </div>
            </form>
        @endif
        <qas></qas>
    </div>
@stop
