@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Audit Logs</h2>

    <a href="{{ route('products.index') }}" class="btn btn-primary">
        Back To Products
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Filter Form --}}
<form method="GET" action="/audit-logs" class="row g-3 mb-4">

    <div class="col-md-4">
        <select name="action" class="form-select">

            <option value="">-- Filter By Action --</option>

            <option value="INSERT"
                {{ request('action') == 'INSERT' ? 'selected' : '' }}>
                INSERT
            </option>

            <option value="UPDATE"
                {{ request('action') == 'UPDATE' ? 'selected' : '' }}>
                UPDATE
            </option>

            <option value="DELETE"
                {{ request('action') == 'DELETE' ? 'selected' : '' }}>
                DELETE
            </option>

        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-dark w-100">
            Filter
        </button>
    </div>

    <div class="col-md-2">
        <a href="/audit-logs" class="btn btn-secondary w-100">
            Reset
        </a>
    </div>

</form>

{{-- Audit Table --}}
<div class="table-responsive">

    <table class="table table-bordered table-striped align-middle">

        <thead class="table-dark">
            <tr>
                <th width="120">Action</th>
                <th width="150">Table</th>
                <th>Old Data</th>
                <th>New Data</th>
                <th width="180">Created At</th>
            </tr>
        </thead>

        <tbody>

            @forelse($logs as $log)

            <tr>

                <td>
                    <span class="badge
                        bg-{{
                            $log->action == 'INSERT'
                            ? 'success'
                            : ($log->action == 'UPDATE'
                            ? 'warning'
                            : 'danger')
                        }}">
                        {{ $log->action }}
                    </span>
                </td>

                <td>
                    {{ $log->table_name }}
                </td>

                <td>
                    <pre class="mb-0" style="white-space: pre-wrap;">
{{ $log->old_data }}
                    </pre>
                </td>

                <td>
                    <pre class="mb-0" style="white-space: pre-wrap;">
{{ $log->new_data }}
                    </pre>
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y h:i A') }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5" class="text-center text-muted">
                    No Audit Logs Found
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $logs->links() }}
</div>

@endsection