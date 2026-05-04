@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th width="150">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $p)
        <tr>
            <td>{{ $p->p_id }}</td>
            <td>{{ $p->title }}</td>
            <td>₹ {{ $p->price }}</td>
            <td>
                <a href="{{ route('products.edit', $p->p_id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('products.destroy', $p->p_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Delete this product?')" class="btn btn-sm btn-danger">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No Products Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection