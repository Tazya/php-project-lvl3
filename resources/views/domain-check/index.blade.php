@if ($domainChecks)
    <table class="table table-bordered table-hover text-nowrap mt-3">
        <tr>
            <th>Id</th>
            <th>Status Code</th>
            <th>h1</th>
            <th>Keywords</th>
            <th>Description</th>
            <th>Created At</th>
        </tr>
        @foreach ($domainChecks as $domainCheck)
            <tr>
                <td>{{ $domainCheck->id }}</td>
                <td>{{ $domainCheck->status_code ?? '' }}</td>
                <td>{{ Str::limit($domainCheck->h1 ?? '...', 30) }}</td>
                <td>{{ Str::limit($domainCheck->keywords ?? '...', 30) }}</td>
                <td>{{ Str::limit($domainCheck->description ?? '...', 30) }}</td>
                <td>{{ $domainCheck->created_at }}</td>
            </tr>
        @endforeach
    </table>
    {!! $domainChecks->links() !!}
@else
    <p>Please, make a first check!</p>
@endif
