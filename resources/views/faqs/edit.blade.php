@extends('layouts.layout')

@section('content')
    <div class="container" id="app">
        @if($isAdminCodeOkay)
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <br>
                    <div class="alert alert-warning" role="alert">
                        <div class="row">
                            <div class="col-12 text-center">
                                <strong>Admin mode:</strong> &nbsp;&nbsp;You can edit this FAQ. Please keep the URL somewhere safe!
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center btn-padding">
                                <button type="button"
                                    class="btn btn-sm btn-outline-warning"
                                    data-clipboard-text="{{$guestLink}}"
                                >
                                    copy guest URL
                                </button>&nbsp;&nbsp;
                                <button type="button"
                                    class="btn btn-sm btn-outline-warning"
                                    data-clipboard-text="{{$adminLink}}"
                                >
                                    copy admin URL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-1">FAQ Me</h1>
                <!-- <p class="lead">FAQ Description</p> -->
            </div>
        </div>
        @if($isAdminCodeOkay)
            <add-qa :is_admin="{{ $isAdminCodeOkay }}" :faq_id="{{ $faq->id }}" :admin_code="'{{ $faq->admin_code }}'"></add-qa>
        @endif
        <qas is_admin="{{ $isAdminCodeOkay }}" faq_id="{{ $faq->id }}"></qas>
    </div>
@stop

@section("afterScript")
    <script type="text/javascript" src="{{ mix('js/clipboard.js') }}"></script>
@stop
