@extends('layouts.app')

@section('title', 'Check your page')

@section('content')
    <main class="flex-grow-1">
        <div class="jumbotron jumbotron-fluid bg-dark">
            <div class="container-lg">
                <div class="row">
                    <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
                        <h1 class="display-3">Page Analyzer</h1>
                        <p class="lead">Check web pages for free</p>
                        {{ Form::open(['route' => 'domains.store', 'class' => 'd-flex justify-content-center']) }}
                            {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'https://www.example.com']) }}
                            {{ Form::submit('Check', ['class' => 'btn btn-lg btn-primary ml-3 px-5 text-uppercase']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
