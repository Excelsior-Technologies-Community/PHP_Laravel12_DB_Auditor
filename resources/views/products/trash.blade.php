@extends('layouts.app')

@section('content')

<h2>Trash Products</h2>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th>Restore</th>
        </tr>
    </thead>

    <tbody>
        @forelse($products as $p)
        <tr>
            <td>{{ $p->p_id }}</td>
            <td>{{ $p->title }}</td>
            <td>₹ {{ $p->price }}</td>

            <td>
                <a href="{{ route('products.restore', $p->p_id) }}"
                    class="btn btn-success btn-sm">
                    Restore
                </a>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="4" class="text-center">
                Trash Empty
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}

@endsection