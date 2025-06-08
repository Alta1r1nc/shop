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
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <span>Пользователи</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                <span>Товары</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="nav-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
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
            <h1>Панель администратора</h1>
            <div class="breadcrumbs">
                <span>Главная</span>
                <span>/</span>
                <span class="current">Пользователи</span>
            </div>
        </div>

        <div class="content-card">
            <h2>Список пользователей</h2>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection