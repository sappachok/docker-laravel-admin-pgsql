<body>
    <table class="table table-striped table-bordered">
    <thead>
        <th>Date</th>
        <th>Username</th>
        <th>Count</th>
        <th>Last access</th>
    </thead>
    <tbody>
    @foreach ($data5 as $data)
        <tr>
            <td>{{ $data["lastdate"] }}</td>
            <td><a href="{{ route('admin.kong-logs.index') }}?consumer->username={{ $data['uname'] }}">{{ $data["uname"] }}</a></td>
            <td>{{ $data["count"] }}</td>
            <td>{{ $data["last_url"] }}</td>
        </tr>
    @endforeach    
    </tbody>
    </table>
</body>