@if($products->isEmpty())
<p>Товары не найдены.</p>
@else
@foreach ($products as $product)
<div class="cat_item pad40">
    <a href="{{ route('product.show', $product->id) }}">
        <img src="{{ asset('storage/' . $product->image) }}" class="cat_img" alt="{{ $product->name }}">
    </a>
    <p class="item_name">{{ $product->name }}</p>
    <p class="item_price">{{ number_format($product->price, 0, '', ' ') }} Р</p>
    <div class="cart_n_like">
        @php
        $cartItem = $cartItems[$product->id] ?? null;
        @endphp

        @if($cartItem)
        <div class="quantity-control">
            <button class="qty-btn minus" data-product="{{ $product->id }}">-</button>
            <span class="qty">{{ $cartItem->quantity }}</span>
            <button class="qty-btn plus" data-product="{{ $product->id }}">+</button>
        </div>
        @else
        <form class="add-to-cart-form" data-product="{{ $product->id }}">
            @csrf
            <button type="submit" class="cat_cart">
                <img src="{{ asset('assets/media/cart_n_like/cart_cat.png') }}" alt="cart">
            </button>
        </form>
        @endif
    </div>
</div>
@endforeach
@endif