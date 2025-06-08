<footer id="footer">
    <section class="max foot_flex">
        <div class="social">
            <p class="we_a_soc">Мы в соцсетях:</p>
            <div class="socials">
                <img src="{{ asset('assets/media/socials/whatsapp.svg') }}" alt="#">
                <img src="{{ asset('assets/media/socials/vkontakte.svg') }}" alt="#">
                <img src="{{ asset('assets/media/socials/telegram.svg') }}" alt="#">
            </div>
            <a class="foot_mail" href="mailto:time_lab@mail.ru">time_lab@mail.ru</a>
            <img class="logo_foot" src="{{ asset('assets/media/logo/logo_foot.svg') }}" alt="Timelab">
        </div>
        <div class="nav_foot">
            <a class="nav_select" href="{{ route('home') }}">каталог</a>
            <a href="{{ route('home') }}#preim">преимущества</a>
            <a href="#footer">контакты</a>
        </div>
    </section>
    <div class="copyright">
        <p class="copy_name">@Быков Матвей, 2025 г.</p>
    </div>
</footer>