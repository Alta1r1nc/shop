<header>
    <div class="max">
        <div class="header-container">
            <!-- Логотип -->
            <a href="{{ route('home') }}" class="logo-link">
                <img class="logo_head" src="{{ asset('assets/media/logo/logo_head.svg') }}" alt="Timelab">
            </a>

            <!-- Бургер-кнопка -->
            <input type="checkbox" id="burger" class="burger-checkbox">
            <label for="burger" class="burger-btn">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </label>

            <!-- Основное меню + элементы авторизации -->
            <nav class="main-nav">
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link">каталог</a>
                    <a href="{{ route('home') }}#preim" class="nav-link">преимущества</a>
                    <a href="#footer" class="nav-link">контакты</a>
                    
                    @auth
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users') }}" class="nav-link">админ-панель</a>
                    @endif
                    <a href="{{ route('profile') }}" class="nav-link">профиль</a>
                    @endauth
                </div>
                
                <div class="nav-actions">
                    <a href="{{ route('cart.show') }}" class="nav-cart">
                        <img src="{{ asset('assets/media/cart_n_like/cart_head.png') }}" alt="Корзина">
                    </a>
                    
                    <div class="auth-buttons">
                        @auth
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="nav-auth-btn logout">Выход</button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="nav-auth-btn login">Вход</a>
                        <a href="{{ route('register') }}" class="nav-auth-btn register">Регистрация</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>