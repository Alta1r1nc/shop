@extends('layouts.app')

@section('content')
<section class="max">
    <div class="hleb pb60">
        <a href="{{ route('home') }}">Каталог</a>
        <img src="{{ asset('assets/media/arrows/hleb.png') }}" alt="#">
        <a href="">{{ $product->name }}</a>
    </div>

    <div class="item pb120">
        <div class="card_img">
            <img src="{{ asset('storage/' . $product->image) }}" class="item_img" alt="{{ $product->name }}">
        </div>
        <div class="item_info">
            <p class="card_name">{{ $product->name }}</p>
            <p class="card_opis"><span>Описание: </span>{{ $product->description }}</p>
            <p class="card_spec">Характеристики:</p>
            <div class="specification">
                <div class="type">
                    <p class="name_spec">Тип:</p>
                    <p class="text_spec">{{ $product->type }}</p>
                </div>
                <div class="type">
                    <p class="name_spec">Бренд:</p>
                    <p class="text_spec">{{ $product->brand }}</p>
                </div>
                <div class="type">
                    <p class="name_spec">Страна:</p>
                    <p class="text_spec">{{ $product->country }}</p>
                </div>
                <div class="type">
                    <p class="name_spec">Артикул:</p>
                    <p class="text_spec">{{ $product->article }}</p>
                </div>
            </div>

            <div class="price_n_cart">
                <p class="card_price">{{ number_format($product->price, 0, '', ' ') }} Р</p>
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
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Обработка добавления в корзину
        document.addEventListener('submit', async function(e) {
            if (e.target.classList.contains('add-to-cart-form')) {
                e.preventDefault();
                e.stopImmediatePropagation();

                const form = e.target;
                if (form.dataset.processing) return;
                form.dataset.processing = true;

                const productId = form.dataset.product;
                const button = form.querySelector('button[type="submit"]');
                button.disabled = true;

                try {
                    const response = await fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Заменяем форму на контролы количества
                        const html = `
                            <div class="quantity-control">
                                <button class="qty-btn minus" data-product="${productId}">-</button>
                                <span class="qty">${data.item_quantity}</span>
                                <button class="qty-btn plus" data-product="${productId}">+</button>
                            </div>`;
                        form.outerHTML = html;

                        // Показываем уведомление
                        showToast('Товар добавлен в корзину');
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    button.disabled = false;
                    form.dataset.processing = false;
                }
            }
        });

        // Обработка изменения количества
        document.addEventListener('click', async function(e) {
            if (e.target.classList.contains('qty-btn')) {
                const btn = e.target;
                const productId = btn.dataset.product;
                const isPlus = btn.classList.contains('plus');
                const qtyElement = btn.parentElement.querySelector('.qty');
                let newQty = parseInt(qtyElement.textContent);

                newQty = isPlus ? newQty + 1 : Math.max(1, newQty - 1);
                btn.disabled = true;

                try {
                    const response = await fetch(`/cart/update/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: newQty
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        qtyElement.textContent = newQty;

                        // Если количество стало 0, возвращаем кнопку добавления
                        if (newQty === 0) {
                            btn.closest('.quantity-control').outerHTML = `
                                <form class="add-to-cart-form" data-product="${productId}">
                                    @csrf
                                    <button type="submit" class="cat_cart">
                                        <img src="{{ asset('assets/media/cart_n_like/cart_cat.png') }}" alt="cart">
                                    </button>
                                </form>
                            `;
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    btn.disabled = false;
                }
            }
        });

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    });
</script>
@endsection