@extends('layouts.app')

@section('content')

<h2>Audit Logs</h2>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Action</th>
            <th>Table</th>
            <th>Old Data</th>
            <th>New Data</th>
            <th>Time</th>
        </tr>
    </thead>

    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>
                <span class="badge bg-{{ $log->action == 'INSERT' ? 'success' : ($log->action == 'UPDATE' ? 'warning' : 'danger') }}">
                    {{ $log->action }}
                </span>
            </td>
            <td>{{ $log->table_name }}</td>
            <td><pre>{{ $log->old_data }}</pre></td>
            <td><pre>{{ $log->new_data }}</pre></td>
            <td>{{ $log->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection