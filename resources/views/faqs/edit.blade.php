@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1 class="display-1">FAQ Me</h1>
                <p class="lead">FAQ Description</p>
            </div>
        </div>
        @if($isOkay)
            <form method="post" action="" class="">
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
        @forelse($qas as $qa)
            <div class="row">
                <div class="col-lg-10 offset-lg-2 col-md-8 ">
                    <b>Q: {{$qa->question}}</b>
                    <p class="lead">A: {{$qa->answer}}</p>
                </div>
                <hr>
            </div>
        @empty
            <div class="row">
                <div class="col text-center">
                    <p class="lead">No comments</p>
                </div>
            </div>
        @endforelse
    </div>
@stop