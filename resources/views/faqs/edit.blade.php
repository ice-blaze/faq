@extends('layouts.layout')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col text-center">
                <h1 class="display-1">FAQ Me</h1>
                <p class="lead">FAQ Description</p>
            </div>
        </div>
        @if($isAdminCodeOkay)
            <add-qa :is_admin="{{ $isAdminCodeOkay }}" :faq_id="{{ $faq->id }}" :admin_code="'{{ $faq->admin_code }}'"></add-qa>
        @endif
        <qas is_admin="{{ $isAdminCodeOkay }}" faq_id="{{ $faq->id }}"></qas>
    </div>
@stop
