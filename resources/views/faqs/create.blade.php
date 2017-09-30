@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <br>
                <h1 class="display-4">Create now your FAQ !</h1>
                <hr>
                <br>

            </div>
        </div>
        <add-qa id="app" :is_admin="false" :faq_id="false" :admin_code="false"></add-qa>
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
