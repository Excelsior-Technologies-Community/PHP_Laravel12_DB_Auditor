@extends('layouts.app')

@section('content')

<h2>Add Product</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input type="text" name="price" class="form-control">
            </div>

            <button class="btn btn-success">Save</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

@endsection