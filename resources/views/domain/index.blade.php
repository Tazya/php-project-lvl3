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
        <tr>
            <td>1</td>
            <td><a href="https://php-l3-page-analyzer.herokuapp.com/domains/1">https://yandex.ru</a></td>
            <td>2020-07-30 06:13:39 </td>
            <td>200</td>
        </tr>
    </table>
</div>
@endsection
