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
            <a href="{{ route('admin.products.index') }}" class="nav-item active">
                <span>Товары</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="nav-item">
                <span>Добавить товар</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
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
            <h1>Управление товарами</h1>
            <div class="breadcrumbs">
                <a href="{{ route('admin.products.index') }}">Главная</a>
                <span>/</span>
                <span class="current">Товары</span>
            </div>
        </div>

        <div class="content-card">
            <div class="products-grid">
                @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/media/no-image.jpg') }}" 
                             alt="{{ $product->name }}">
                    </div>
                    
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-price">{{ number_format($product->price, 0, '', ' ') }} ₽</p>
                        
                        <div class="product-actions">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn edit-btn">
                                <span>Редактировать</span>
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" 
                                  class="delete-form" onsubmit="return confirm('Удалить товар?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">
                                    <span>Удалить</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection