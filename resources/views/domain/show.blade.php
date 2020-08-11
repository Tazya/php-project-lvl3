@extends('layouts.app')

@section('title', 'Domain')

@section('content')

<div class="container-lg">
    <h1 class="mt-5 mb-3">Site: {{ $domain->name }}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>Id</td>
                    <td>{{ $domain->id }}</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $domain->name }}</td>
                </tr>
                <tr>
                    <td>Created At</td>
                    <td>{{ $domain->created_at }}</td>
                </tr>
                <tr>
                    <td>Updated At</td>
                    <td>{{ $domain->updated_at }}</td>
                </tr>
        </table>
    </div>
    <h2 class="mt-5 mb-3">Checks</h2>
    <button data-domain-id="{{ $domain->id }}" class="btn btn-primary domain-check-btn">Run check</button>
    <div id="domain-checks" data-domain-id="{{ $domain->id }}">

    </div>
@endsection
