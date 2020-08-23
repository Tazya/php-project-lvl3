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
                        <form action="{{ route('domains.store') }}" method="post" class="d-flex justify-content-center">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="name" value="" class="form-control form-control-lg" placeholder="https://www.example.com">
                        <button type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase">Check</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection