@extends('layouts.app')

@section('title', 'All domains')

@section('content')
<h1 class="mt-5 mb-3">Domains</h1>
<div class="table-responsive">
    <table class="table table-bordered table-hover text-nowrap">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last check</th>
            <th>Status Code</th>
        </tr>
        @foreach ($domains as $domain)
            <tr>
                <td>{{ $domain->id }}</td>
                <td><a href="{{ route('domains.show', $domain->id) }}">{{ $domain->name }}</a></td>
                <td>{{ $domain->updated_at }}</td>
                <td>200</td>
            </tr>
        @endforeach

    </table>
</div>
@endsection
