@extends('layouts.app')

@section('content')

<h2>Edit Product</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('products.update', $product->p_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ $product->title }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input type="text" name="price" value="{{ $product->price }}" class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

@endsection