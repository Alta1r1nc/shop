@extends('layouts.app')

@section('content')
<!-- Баннер -->
<section class="banner max pb120">
    <div class="lider">
        <p class="lider_name">Лидер продаж</p>
        <p class="lider_text">Часы наручные кварцевые <span>LAMBRUSSO JEANS</span></p>
        <p class="lider_price">18 069 <span>₽</span></p>
        <a href="{{ route('home') }}#catalog"><button class="ban_btn">Купить сейчас</button></a>
    </div>
    <img class="ban_img" src="{{ asset('assets/media/banner/ban1.png') }}" alt="LAMBRUSSO JEANS">
    <div class="slider-dots"></div>
</section>

<!-- Промо -->
<section class="pb120 max">
    <div class="promo">
        <p class="promo_text">Получи промокод на скидку <span>10%</span> подписавшись на рассылку по почте</p>
        <img class="romb" src="{{ asset('assets/media/arrows/arrow_form.png') }}" alt="romb">
        <div class="promo_forma">
            <form class="promo_gap" action="#">
                <input class="promo_inp" type="email" placeholder="Email">
                <button class="promo_btn">Отправить</button>
            </form>
            <div class="soglasie">
                <input type="checkbox" name="#" id="#">
                <a href="{{ asset('assets/media/politic/politikaconf.rtf') }}" download="">
                    <p class="sogl_text">отправляя запрос вы соглашаетесь на обработку данных</p>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Каталог -->
<section class="max pb120" id="catalog">
    <p class="cat_name">Каталог</p>
    <!-- Фильтры, поиск и сортировка -->
    <div class="cat_find">
        <div class="filtr">
            <a class="{{ $type === 'все' || !$type ? 'active' : '' }}" href="#" data-type="все">все</a>
            <a class="{{ $type === 'механические' ? 'active' : '' }}" href="#"
                data-type="механические">механические</a>
            <a class="{{ $type === 'электронные' ? 'active' : '' }}" href="#"
                data-type="электронные">электронные</a>
            <a class="{{ $type === 'кварцевые' ? 'active' : '' }}" href="#" data-type="кварцевые">кварцевые</a>
        </div>
        <div class="poisk">
            <form id="searchForm">
                <input type="text" name="search" placeholder="Поиск" value="{{ $search }}">
                <button type="submit">Найти</button>
            </form>
            <select id="sortSelect">
                <option value="">Сортировать по</option>
                <option value="cheap" {{ $sort === 'cheap' ? 'selected' : '' }}>дешевле</option>
                <option value="expensive" {{ $sort === 'expensive' ? 'selected' : '' }}>дороже</option>
            </select>
        </div>
    </div>

    <!-- Список товаров -->
    <div class="items">
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
    </div>
</section>

<!-- Преимущества -->
<section class="preim" id="preim">
    <div class="max">
        <p class="preim_name pt120 pb60">Преимущества</p>
        <div class="preim_spisok pb120">
            <div class="preim_punkt">
                <img src="{{ asset('assets/media/preim/1.png') }}" alt="#">
                <p class="preim_text">Самые низкие цены</p>
            </div>
            <div class="preim_punkt">
                <img src="{{ asset('assets/media/preim/2.png') }}" alt="#">
                <p class="preim_text">#1 магазин часов в России</p>
            </div>
            <div class="preim_punkt">
                <img src="{{ asset('assets/media/preim/3.png') }}" alt="#">
                <p class="preim_text">Доставка до 3-х дней</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="max">
    <p class="faq_name pt120 pb60">Вопросы и ответы</p>
    <div class="faq pb120">
        <div class="faq_item">
            <div class="faq_content">
                <div class="faq_question">
                    Как узнать размер своего запястья?
                    <img class="faq_icon" src="assets/media/arrows/faq_pass.png" alt="+">
                </div>
                <div class="faq_answer">
                    Чтобы определить размер запястья, используйте мягкую сантиметровую ленту или полоску бумаги. Оберите
                    ее вокруг запястья и отметьте длину. Затем сравните с нашей таблицей размеров в разделе руководства
                    по размерам.
                </div>
            </div>
        </div>
        <div class="faq_item">
            <div class="faq_content">
                <div class="faq_question">
                    Какие способы оплаты доступны?
                    <img class="faq_icon" src="assets/media/arrows/faq_pass.png" alt="+">
                </div>
                <div class="faq_answer">
                    Мы принимаем различные способы оплаты, включая кредитные карты, PayPal и банковские переводы.
                </div>
            </div>
        </div>
        <div class="faq_item">
            <div class="faq_content">
                <div class="faq_question">
                    Есть ли гарантия на часы?
                    <img class="faq_icon" src="assets/media/arrows/faq_pass.png" alt="+">
                </div>
                <div class="faq_answer">
                    Да, на все наши часы предоставляется гарантия сроком на 2 года.
                </div>
            </div>
        </div>
        <div class="faq_item">
            <div class="faq_content">
                <div class="faq_question">
                    Как оформить доставку?
                    <img class="faq_icon" src="assets/media/arrows/faq_pass.png" alt="+">
                </div>
                <div class="faq_answer">
                    Доставка оформляется при оформлении заказа. Вы можете выбрать удобный для вас способ доставки и
                    оплаты.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.querySelector('.banner');
        const images = [{
                src: 'assets/media/banner/ban.png',
                text: 'Часы наручные кварцевые <span>LAMBRUSSO JEANS</span>',
                price: '18 000'
            },
            {
                src: 'assets/media/banner/ban2.jpg',
                text: 'Часы наручные кварцевые <span>BRAND NEW</span>',
                price: '20 000'
            },
            {
                src: 'assets/media/banner/ban3.png',
                text: 'Часы наручные кварцевые <span>CLASSIC</span>',
                price: '15 000'
            }
        ];

        const imgElement = banner.querySelector('.ban_img');
        const textElement = banner.querySelector('.lider_text');
        const priceElement = banner.querySelector('.lider_price');
        const dotsContainer = banner.querySelector('.slider-dots');

        let currentIndex = 0;

        // Создаем точки-индикаторы
        function createDots() {
            dotsContainer.innerHTML = '';
            images.forEach((_, index) => {
                const dot = document.createElement('span');
                dot.classList.add('dot');
                if (index === currentIndex) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    currentIndex = index;
                    updateBanner();
                    updateDots();
                });
                dotsContainer.appendChild(dot);
            });
        }

        // Обновляем активную точку
        function updateDots() {
            const dots = dotsContainer.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function updateBanner() {
            imgElement.src = images[currentIndex].src;
            textElement.innerHTML = images[currentIndex].text;
            priceElement.innerHTML = `${images[currentIndex].price} <span>₽</span>`;
        }

        // Автопереключение слайдов
        function autoSlide() {
            currentIndex = (currentIndex + 1) % images.length;
            updateBanner();
            updateDots();
        }

        let slideInterval = setInterval(autoSlide, 3000);

        // Останавливаем автопереключение при наведении
        banner.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        // Возобновляем автопереключение при уходе курсора
        banner.addEventListener('mouseleave', () => {
            slideInterval = setInterval(autoSlide, 3000);
        });

        // Инициализация
        createDots();
        updateBanner();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Добавление в корзину
        const addToCartForms = document.querySelectorAll('.add-to-cart-form:not([data-handler-attached])');

        addToCartForms.forEach(form => {
            form.dataset.handlerAttached = 'true';

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                if (this.dataset.processing) return;
                this.dataset.processing = true;

                const productId = this.dataset.product;
                console.log('Adding product:', productId); // Логирование

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
                        const html = `
                    <div class="quantity-control">
                        <button class="qty-btn minus" data-product="${productId}">-</button>
                        <span class="qty">1</span>
                        <button class="qty-btn plus" data-product="${productId}">+</button>
                    </div>`;
                        this.outerHTML = html;
                        showToast('Товар добавлен в корзину');
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.dataset.processing = false;
                }
            });
        });

        // Управление количеством
        document.addEventListener('click', async function(e) {
            if (e.target.classList.contains('qty-btn')) {
                const btn = e.target;
                const productId = btn.dataset.product;
                const isPlus = btn.classList.contains('plus');
                const qtyElement = btn.parentElement.querySelector('.qty');
                let newQty = parseInt(qtyElement.textContent);

                newQty = isPlus ? newQty + 1 : Math.max(1, newQty - 1);

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
                        if (newQty === 0) {
                            // Возвращаем исходную кнопку
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
    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('.faq_item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq_question');
            const answer = item.querySelector('.faq_answer');
            const icon = item.querySelector('.faq_icon');

            question.addEventListener('click', function() {
                if (item.classList.contains('active')) {
                    // Закрываем текущий элемент
                    item.classList.remove('active');
                    answer.classList.remove('active');
                    icon.src =
                        'assets/media/arrows/faq_pass.png'; // Иконка для закрытого состояния
                } else {
                    // Закрываем все другие элементы
                    faqItems.forEach(el => {
                        el.classList.remove('active');
                        el.querySelector('.faq_answer').classList.remove('active');
                        el.querySelector('.faq_icon').src =
                            'assets/media/arrows/faq_pass.png';
                    });

                    // Открываем текущий элемент
                    item.classList.add('active');
                    answer.classList.add('active');
                    icon.src =
                        'assets/media/arrows/faq_active.png'; // Иконка для открытого состояния
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterLinks = document.querySelectorAll('.filtr a');
        const searchForm = document.querySelector('#searchForm');
        const sortSelect = document.querySelector('#sortSelect');

        // Общая функция для отправки запроса
        async function applyFilters() {
            const activeFilter = document.querySelector('.filtr a.active');
            const searchQuery = searchForm.querySelector('input[name="search"]').value;
            const sortValue = sortSelect.value;

            const params = new URLSearchParams({
                type: activeFilter ? activeFilter.dataset.type : 'все',
                search: searchQuery,
                sort: sortValue,
            });

            try {
                const response = await fetch(`{{ route('home') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) throw new Error('Network error');

                const data = await response.json();

                if (data.html) {
                    document.querySelector('.items').innerHTML = data.html;
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при загрузке данных');
            }
        }

        // Обработчики событий
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                filterLinks.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });

        sortSelect.addEventListener('change', applyFilters);
    });
</script>
@endsection