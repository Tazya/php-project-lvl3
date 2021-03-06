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
                <td>{{ $domain->last_check_created_at }}</td>
                <td>{{ $domain->last_check_status_code }}</td>
            </tr>
        @endforeach
    </table>
    {{ $domains->links() }}
</div>
@endsection
