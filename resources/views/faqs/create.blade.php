@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <br>
                <h1 class="display-3">FAQme</h1>
                <hr>
                <h1 class="display-4">Create now your FAQ !</h1>
                <br>

            </div>
        </div>
        <form method="post" action="/faq/create">
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
                    {!! Recaptcha::render() !!}
                    <br/>
                    {{-- {!! app('captcha')->render(); !!} --}}
                    <button type="submit" class="btn btn-primary">Add Question</button>
                    <br/>
                    <br/>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                @foreach ($fake_qas as $qa)
                    <div class="card qa">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-11">
                                    <strong>{{$qa["question"]}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <cite class="card-blockquote">{{$qa["answer"]}}</cite>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="row">
                                <div class="col-11">
                                    {{$qa["time"]}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section("afterScript")
    <script type="text/javascript" src="{{ mix('js/autosize.js') }}"></script>
@stop
