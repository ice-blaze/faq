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
        @forelse($qas as $qa)
            <div class="row qa">
                @if($isOkay)
                    <div class="col-lg-1">
                        <!-- TODO use icons -->
                        <div class="btn btn-primary edit-button" id="edit-button-{{$qa->id}}">edit</div>
                    </div>

                    <div class="col-lg-1">
                        <form method="post" action="/{{$faq->id}}/{{$faq->admin_code}}/qas/{{$qa->id}}/up">
                            {{ csrf_field() }}
                            <!-- TODO use icons -->
                            <button type="submit" class="btn btn-primary">up</button>
                        </form>
                        <form method="post" action="/{{$faq->id}}/{{$faq->admin_code}}/qas/{{$qa->id}}/down">
                            {{ csrf_field() }}
                            <!-- TODO use icons -->
                            <button type="submit" class="btn btn-primary">down</button>
                        </form>
                    </div>
                @endif
                <div class="col-lg-10 offset-lg-2 col-md-8 ">
                    <div class="edit-qa">
                        @if($isOkay)
                            <form method="post" action="" class="">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="question" class="col-sm-1 col col-form-label">Q:</label>
                                    <input name="question" type="text" class="form-control col-sm-8" value="{{$qa->question}}"></input></b>
                                </div>
                                <div class="form-group row">
                                    <label for="answer" class="col-sm-1 col col-form-label">A:</label>
                                    <textarea class="form-control col-sm-8" name="answer"
                                        aria-describedby="answer" placeholder="Anser the question">{{$qa->answer}}</textarea>
                                    <input type="hidden" name="qa_id" value="{{$qa->id}}">
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary offset-sm-1">Update QA</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <div class="display-qa">
                        <b>Q: {{$qa->question}}</b>
                        <p class="lead">A: {{$qa->answer}}</p>
                    </div>
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

@section('afterScript')
    <script type="text/javascript" src="{{ asset('js/edit-qa.js') }}"></script>
@stop
