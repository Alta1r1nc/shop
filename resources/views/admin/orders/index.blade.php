@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <!-- Боковое меню -->
    <div class="admin-sidebar">
        <div class="admin-header">
            <a href="{{ route('home') }}" class="admin-logo">
                <img src="{{ asset(path: 'assets/media/logo/logo_head.svg') }}" alt="Логотип">
            </a>
            <div class="admin-user">
                <img src="{{ asset('assets/media/adm_panel/avatar.png') }}" alt="Аватар" class="user-avatar">
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
                    <a href="mailto:{{ Auth::user()->email }}" class="user-email">{{ Auth::user()->email }}</a>
                </div>
            </div>
        </div>

        <nav class="admin-nav">
            <a href="{{ route('admin.users') }}" class="nav-item">
                <span>Пользователи</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-item">
                <span>Товары</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="nav-item">
                <span>Добавить товар</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="nav-item active">
                <span>Заказы</span>
            </a>
        </nav>

        <a href="{{ route('profile') }}" class="back-link">
            <span>Вернуться в профиль</span>
        </a>
    </div>

    <!-- Основное содержимое -->
    <div class="admin-content">
        <div class="content-header">
            <h1>Управление заказами</h1>
            <div class="breadcrumbs">
                <a href="{{ route('admin.products.index') }}">Главная</a>
                <span>/</span>
                <span class="current">Заказы</span>
            </div>
        </div>

        <div class="content-card">
            <div class="orders-list">
                @foreach($orders as $order)
                <div class="order-card status-{{ $order->status }}">
                    <div class="order-header">
                        <div class="order-meta">
                            <span class="order-id">Заказ #{{ $order->id }}</span>
                            <span class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                            <span class="order-status-badge">{{ $order->status_text }}</span>
                        </div>

                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="status-form">
                            @csrf
                            <select name="status" class="status-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>В обработке</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                            </select>
                            <button type="submit" class="status-save-btn">
                                <p>Сохранить</p>
                            </button>
                        </form>
                    </div>

                    <div class="order-body">
                        <div class="order-section customer-info">
                            <h3 class="section-title">Клиент</h3>
                            <div class="section-content">
                                <p><strong>Имя:</strong> {{ $order->name }}</p>
                                <p><strong>Телефон:</strong> {{ $order->phone }}</p>
                                <p><strong>Email:</strong> {{ $order->email }}</p>
                                @if($order->address)
                                <p><strong>Адрес:</strong> {{ $order->address }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="order-section order-items">
                            <h3 class="section-title">Товары</h3>
                            <div class="section-content">
                                @foreach($order->items as $item)
                                <div class="order-item">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="item-image" alt="{{ $item->product->name }}">
                                    <div class="item-details">
                                        <p class="item-name">{{ $item->product->name }}</p>
                                        <p class="item-quantity-price">
                                            {{ $item->quantity }} × {{ number_format($item->price, 0, '', ' ') }} ₽
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="order-footer">
                        <div class="order-total">
                            <span>Итого:</span>
                            <span class="total-amount">{{ number_format($order->total, 0, '', ' ') }} ₽</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($orders->hasPages())
            <div class="pagination-wrapper">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Автоматическая отправка формы при изменении статуса
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                // Подсветка кнопки сохранения
                const form = this.closest('.status-form');
                const saveBtn = form.querySelector('.status-save-btn');
                saveBtn.style.backgroundColor = 'rgba(0, 182, 182, 0.2)';

                // Можно раскомментировать для автоматической отправки
                // form.submit();
            });
        });
    });
</script>
@endsection