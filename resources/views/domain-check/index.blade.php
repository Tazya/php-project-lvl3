@if ($domainChecks)
    <table class="table table-bordered table-hover text-nowrap">
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
                <td>{{ $domainCheck->h1 ?? '' }}</td>
                <td>{{ $domainCheck->keywords ?? '' }}</td>
                <td>{{ $domainCheck->description ?? '' }}</td>
                <td>{{ $domainCheck->created_at }}</td>
            </tr>
        @endforeach
    </table>
@else
    <p>Please, make a first check!</p>
@endif
