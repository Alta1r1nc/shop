@extends('layouts.app')

@section('content')
<section class="max pb120">
    @guest
    <div class="auth-required-container">
        <div class="auth-required-card">
            <h2 class="auth-required-title">Требуется авторизация</h2>
            <p class="auth-required-text">Для просмотра корзины необходимо войти в свой аккаунт</p>

            <div class="auth-required-buttons">
                <a href="{{ route('login') }}" class="auth-required-btn login-btn">
                    Войти
                </a>
                <a href="{{ route('register') }}" class="auth-required-btn register-btn">
                    Зарегистрироваться
                </a>
            </div>

            <p class="auth-required-footer">Нет аккаунта? <a href="{{ route('register') }}" class="auth-required-link">Создайте его</a></p>
        </div>
    </div>
    @else
    <h1 class="cat_name">Ваша корзина</h1>

    @if($cart->items->isEmpty())
    <div class="empty-cart">
        <p>Ваша корзина пуста</p>
        <a href="{{ route('home') }}" class="back-to-shop">Вернуться в магазин</a>
    </div>
    @else
    <div class="cart-container">
        <div class="cart-items">
            @foreach($cart->items as $item)
            <div class="cart-item" data-product-id="{{ $item->product_id }}">
                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                <div class="item-details">
                    <h3>{{ $item->product->name }}</h3>
                    <p class="item-brand">{{ $item->product->brand }}</p>
                    <div class="item-actions">
                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-item trash">
                                <img src="{{ asset('assets/media/cart/trash-icon.svg') }}" alt="Удалить">
                            </button>
                        </form>
                        <div class="quantity-control">
                            <button class="qty-btn minus">-</button>
                            <span class="qty">{{ $item->quantity }}</span>
                            <button class="qty-btn plus">+</button>
                        </div>
                    </div>
                </div>
                <div class="item-price" data-unit-price="{{ $item->product->price }}">
                    {{ number_format($item->product->price * $item->quantity, 0, '', ' ') }} ₽
                </div>
            </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <h3>Итого</h3>
            <div class="summary-row">
                <span>Товары ({{ $cart->items->sum('quantity') }})</span>
                <span>{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 0, '', ' ') }} ₽</span>
            </div>
            <div class="summary-row total">
                <span>Общая сумма</span>
                <span>{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 0, '', ' ') }} ₽</span>
            </div>
            <div class="checkout-form">
                <h2>Оформление заказа</h2>
                <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="name" placeholder="Ваше имя" required
                            value="{{ old('name', auth()->user()->name ?? '') }}"
                            class="@error('name') error @enderror">
                        @error('name')<div class="error-text">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required
                            value="{{ old('email', auth()->user()->email ?? '') }}"
                            class="@error('email') error @enderror">
                        @error('email')<div class="error-text">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Телефон" required
                            value="{{ old('phone') }}"
                            class="@error('phone') error @enderror">
                        @error('phone')<div class="error-text">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <textarea name="address" placeholder="Адрес доставки" required
                            class="@error('address') error @enderror">{{ old('address') }}</textarea>
                        @error('address')<div class="error-text">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="checkout-btn">Оформить заказ</button>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endguest

    <script>
        // Маска для телефона
        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                e.target.value = !x[2] ? x[1] : x[1] + ' (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');

                // Ограничение длины (максимум 18 символов: +7 (123) 456-78-90)
                if (e.target.value.length > 18) {
                    e.target.value = e.target.value.slice(0, 18);
                }
            });

            // Валидация при отправке формы
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                const phone = phoneInput.value.replace(/\D/g, '');
                if (phone.length < 11) {
                    e.preventDefault();
                    alert('Номер телефона должен содержать 11 цифр');
                    phoneInput.focus();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка кнопок количества
            document.querySelectorAll('.quantity-control').forEach(control => {
                const minus = control.querySelector('.minus');
                const plus = control.querySelector('.plus');
                const qtySpan = control.querySelector('.qty');
                const itemRow = control.closest('.cart-item');
                const itemPriceElement = itemRow.querySelector('.item-price');

                async function updateQuantity(newQty) {
                    if (newQty < 1) return;

                    const productId = itemRow.dataset.productId;
                    itemRow.classList.add('updating');

                    try {
                        const response = await fetch(`/cart/update/${productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                quantity: newQty
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Обновляем количество
                            qtySpan.textContent = newQty;

                            // Обновляем цену позиции
                            itemPriceElement.textContent = `${Math.round(data.itemTotal).toLocaleString('ru-RU')} ₽`;

                            // Обновляем итоговые суммы
                            updateSummary(data.itemsCount, data.subtotal);
                        } else {
                            console.error('Ошибка обновления:', data.message);
                            alert(data.message || 'Ошибка обновления количества');
                        }
                    } catch (error) {
                        console.error('Ошибка сети:', error);
                        alert('Ошибка соединения с сервером');
                    } finally {
                        itemRow.classList.remove('updating');
                    }
                }

                minus.addEventListener('click', () => {
                    const currentQty = parseInt(qtySpan.textContent);
                    updateQuantity(currentQty - 1);
                });

                plus.addEventListener('click', () => {
                    const currentQty = parseInt(qtySpan.textContent);
                    updateQuantity(currentQty + 1);
                });
            });

            // Функция обновления итоговых сумм
            function updateSummary(itemsCount, subtotal) {
                // Обновляем количество товаров
                const itemsCountElement = document.querySelector('.summary-row span:first-child');
                if (itemsCountElement) {
                    itemsCountElement.textContent = `Товары (${itemsCount})`;
                }

                // Обновляем суммы
                document.querySelectorAll('.summary-row').forEach(row => {
                    if (row.classList.contains('total')) {
                        row.querySelector('span:last-child').textContent = `${Math.round(subtotal).toLocaleString('ru-RU')} ₽`;
                    } else if (row.textContent.includes('Товары')) {
                        row.querySelector('span:last-child').textContent = `${Math.round(subtotal).toLocaleString('ru-RU')} ₽`;
                    }
                });
            }
        });

        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner"></div> Обработка...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form)
                });

                const data = await response.json();

                if (response.ok && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    // Очистка предыдущих ошибок
                    form.querySelectorAll('.error-text').forEach(el => el.remove());
                    form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('error');
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'error-text';
                                errorDiv.textContent = messages[0];
                                input.parentNode.insertBefore(errorDiv, input.nextSibling);
                            }
                        });
                    }
                    alert(data.message || 'Произошла ошибка при оформлении заказа');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Ошибка сети или сервера');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Оформить заказ';
            }
        });
    </script>
</section>
@endsection