@extends('layouts.app')

@section('content')
<section class="max">
    <div class="user_flex pb120">
        <div class="user">
            <p class="salam pb60">Приветствуем, {{ $user->name }}!</p>
            <div class="user_profile pb60">
                <img src="{{ asset('assets/media/user/ava.png') }}" alt="Аватар">
                <div class="name_mail">
                    <p class="user_name">{{ $user->name }} {{ $user->surname }}</p>
                    <p class="user_email">{{ $user->email }}</p>
                </div>
            </div>

            @if($orders->count() > 0)
            <div class="user-orders">
                <h2 class="my_items_name pb30">Мои заказы</h2>

                @foreach($orders as $order)
                <div class="order-card status-{{ $order->status }}">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Заказ #{{ $order->id }}</span>
                            <span class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                            <span class="order-status">{{ $order->status_text }}</span> <!-- Изменено здесь -->
                        </div>
                        <span class="order-total">{{ number_format($order->total, 0, '', ' ') }} ₽</span>
                    </div>

                    <div class="order-items">
                        @foreach($order->items as $item)
                        <div class="order-item">
                            @if($item->product)
                            <img src="{{ asset('storage/' . $item->product->image) }}" width="60" alt="{{ $item->product->name }}">
                            <div class="item-details">
                                <p class="item-name">{{ $item->product->name }}</p>
                                <p class="item-quantity-price">
                                    {{ $item->quantity }} × {{ number_format($item->price, 0, '', ' ') }} ₽
                                </p>
                            </div>
                            @else
                            <img src="{{ asset('assets/media/user/default-product.png') }}" width="60" alt="Товар недоступен">
                            <div class="item-details">
                                <p class="item-name">Товар недоступен</p>
                                <p class="item-quantity-price">
                                    {{ $item->quantity }} × {{ number_format($item->price, 0, '', ' ') }} ₽
                                </p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="no-orders">
                <p class="my_items_name pb30">Мои заказы</p>
                <p>У вас пока нет заказов</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection