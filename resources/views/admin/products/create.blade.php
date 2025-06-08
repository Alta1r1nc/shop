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
            <a href="{{ route('admin.products.index') }}" class="nav-item ">
                <span>Товары</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="nav-item active">
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
            <h1>Добавление товара</h1>
            <div class="breadcrumbs">
                <a href="{{ route('admin.products.index') }}">Главная</a>
                <span>/</span>
                <span class="current">Новый товар</span>
            </div>
        </div>

        <div class="content-card">
            <form class="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <!-- Левая колонка -->
                    <div class="form-column">
                        <!-- Название -->
                        <div class="form-group">
                            <label>Название товара</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="form-input @error('name') error @enderror"
                                   placeholder="Введите название">
                            @error('name')<div class="error-text">{{ $message }}</div>@enderror
                        </div>

                        <!-- Описание -->
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="description" class="form-textarea @error('description') error @enderror"
                                      placeholder="Добавьте описание товара">{{ old('description') }}</textarea>
                            @error('description')<div class="error-text">{{ $message }}</div>@enderror
                        </div>

                        <!-- Изображение -->
                        <div class="form-group">
                            <label>Изображение товара</label>
                            <div class="file-upload">
                                <label class="file-upload-label">
                                    <input type="file" id="image" name="image" class="file-input">
                                    <span class="file-custom @error('image') error @enderror">
                                        {{ old('image') ? 'Изменить файл' : 'Выберите файл' }}
                                    </span>
                                </label>
                                @error('image')<div class="error-text">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Правая колонка -->
                    <div class="form-column">
                        <!-- Тип -->
                        <div class="form-group">
                            <label>Тип часов</label>
                            <select name="type" class="form-select @error('type') error @enderror">
                                <option value="механические" {{ old('type') == 'механические' ? 'selected' : '' }}>Механические</option>
                                <option value="электронные" {{ old('type') == 'электронные' ? 'selected' : '' }}>Электронные</option>
                                <option value="кварцевые" {{ old('type') == 'кварцевые' ? 'selected' : '' }}>Кварцевые</option>
                            </select>
                            @error('type')<div class="error-text">{{ $message }}</div>@enderror
                        </div>

                        <!-- Бренд -->
                        <div class="form-group">
                            <label>Бренд</label>
                            <input type="text" name="brand" value="{{ old('brand') }}" 
                                   class="form-input @error('brand') error @enderror"
                                   placeholder="Введите бренд">
                            @error('brand')<div class="error-text">{{ $message }}</div>@enderror
                        </div>

                        <!-- Страна -->
                        <div class="form-group">
                            <label>Страна производства</label>
                            <input type="text" name="country" value="{{ old('country') }}" 
                                   class="form-input @error('country') error @enderror"
                                   placeholder="Введите страну">
                            @error('country')<div class="error-text">{{ $message }}</div>@enderror
                        </div>

                        <!-- Артикул -->
                        <div class="form-group">
                            <label>Артикул</label>
                            <input type="text" name="article" value="{{ old('article') }}" 
                                   class="form-input @error('article') error @enderror"
                                   placeholder="Введите артикул">
                            @error('article')<div class="error-text">{{ $message }}</div>@enderror
                        </div>

                        <!-- Цена -->
                        <div class="form-group">
                            <label>Цена</label>
                            <input type="number" name="price" value="{{ old('price') }}" 
                                   class="form-input @error('price') error @enderror"
                                   placeholder="Укажите цену">
                            @error('price')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="form-submit-btn">
                        <img src="{{ asset('assets/media/adm_panel/add.png') }}" alt="Добавить">
                        Создать товар
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection