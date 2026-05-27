@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Audit Dashboard</h2>

    <div class="d-flex gap-2">

        <a href="{{ route('audit.export') }}"
           class="btn btn-success">

            Export CSV

        </a>

        <a href="{{ route('products.index') }}"
           class="btn btn-primary">

            Back To Products

        </a>

    </div>

</div>


@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif



<div class="row mb-4">

<div class="col-md-3">

<div class="card shadow text-center p-3">

<h6>Total Logs</h6>

<h2>

{{ $stats['total_logs'] }}

</h2>

</div>

</div>


<div class="col-md-3">

<div class="card shadow text-center p-3">

<h6>Insert Logs</h6>

<h2>

{{ $stats['insert'] }}

</h2>

</div>

</div>



<div class="col-md-3">

<div class="card shadow text-center p-3">

<h6>Update Logs</h6>

<h2>

{{ $stats['update'] }}

</h2>

</div>

</div>



<div class="col-md-3">

<div class="card shadow text-center p-3">

<h6>Delete Logs</h6>

<h2>

{{ $stats['delete'] }}

</h2>

</div>

</div>

</div>



<div class="card shadow p-4 mb-4">

<h4 class="mb-3">

Audit Analytics

</h4>

<canvas id="auditChart"></canvas>

</div>



<form
method="GET"
action="{{ route('audit.index') }}"
class="row g-3 mb-4"
>

<div class="col-md-4">

<select
name="action"
class="form-select"
>

<option value="">

-- Filter By Action --

</option>


<option value="INSERT"

{{ request('action')=='INSERT' ? 'selected':'' }}

>

INSERT

</option>


<option value="UPDATE"

{{ request('action')=='UPDATE' ? 'selected':'' }}

>

UPDATE

</option>


<option value="DELETE"

{{ request('action')=='DELETE' ? 'selected':'' }}

>

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

<a
href="{{ route('audit.index') }}"
class="btn btn-secondary w-100">

Reset

</a>

</div>

</form>




<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">

<thead class="table-dark">

<tr>

<th width="120">

Action

</th>

<th width="150">

Table

</th>

<th>

Old Data

</th>

<th>

New Data

</th>

<th width="180">

Created At

</th>

</tr>

</thead>


<tbody>

@forelse($logs as $log)

<tr>

<td>

<span class="badge
bg-{{
$log->action=='INSERT'
?'success'
:(
$log->action=='UPDATE'
?'warning'
:'danger'
)
}}">

{{ $log->action }}

</span>

</td>



<td>

{{ $log->table_name }}

</td>



<td>

<pre
class="mb-0"
style="white-space:pre-wrap"
>

{{ $log->old_data }}

</pre>

</td>



<td>

<pre
class="mb-0"
style="white-space:pre-wrap"
>

{{ $log->new_data }}

</pre>

</td>



<td>

{{ \Carbon\Carbon::parse(
$log->created_at
)->format('d M Y h:i A') }}

</td>

</tr>

@empty

<tr>

<td
colspan="5"
class="text-center text-muted"
>

No Audit Logs Found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>



<div class="mt-3">

{{ $logs->links() }}

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const auditChart =
document.getElementById(
'auditChart'
);

new Chart(auditChart, {

type:'bar',

data:{

labels:[
'INSERT',
'UPDATE',
'DELETE'
],

datasets:[{

label:'Audit Activities',

data:[

{{ $chartData[0] }},
{{ $chartData[1] }},
{{ $chartData[2] }}

]

}]

},

options:{

responsive:true

}

});

</script>

@endsection