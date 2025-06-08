@extends('layouts.app')

@section('content')
<div class="admin">
    <div class="items_adm">
        @foreach($products as $product)
        <div class="cat_item pad40">
            <img src="{{ asset('storage/'.$product->image) }}" class="cat_img">
            <p class="item_name">{{ $product->name }}</p>
            <div class="cart_n_like">
                <a href="{{ route('admin.products.edit', $product->id) }}">
                    <img src="{{ asset('assets/media/adm_panel/edit.svg') }}">
                </a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <img src="{{ asset('assets/media/adm_panel/delete.svg') }}">
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection