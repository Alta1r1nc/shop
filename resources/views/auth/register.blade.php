@extends('layouts.app')

@section('content')
<div class="reg_flex pb120">
    <div class="reg">
        <p class="reg_name pt60">Регистрация</p>
        <p class="reg_text pb60">Мы ждем именно вас :)</p>
        <form class="form_reg" method="POST" action="{{ route('register') }}">
            @csrf
            <input class="inp_reg @error('name') error @enderror" name="name" type="text" placeholder="имя">
            @error('name')
                <p style="color: red">{{ $message }}</p>
            @enderror

            <input class="inp_reg @error('surname') error @enderror" name="surname" type="text" placeholder="фамилия">
            @error('surname')
                <p style="color: red">{{ $message }}</p>
            @enderror

            <input class="inp_reg @error('email') error @enderror" name="email" type="text" placeholder="почта">
            @error('email')
                <p style="color: red">{{ $message }}</p>
            @enderror

            <input class="inp_reg @error('password') error @enderror" name="password" type="password" placeholder="пароль">
            @error('password')
                <p style="color: red">{{ $message }}</p>
            @enderror

            <input class="inp_reg @error('password_confirmation') error @enderror" name="password_confirmation" type="password" placeholder="повторите пароль">
            @error('password_confirmation')
                <p style="color: red">{{ $message }}</p>
            @enderror

            <button type="submit" class="reg_btn">Регистрация</button>
        </form>
        <div class="politika">
            <input type="checkbox" name="agree" id="agree" required>
            <label for="agree">Отправляя, вы соглашаетесь с <a href="{{ asset('assets/media/politic/politikaconf.rtf') }}" download>политикой сайта</a></label>
        </div>
        <div class="est_acc">
            <p>Уже есть аккаунт?</p>
            <a href="{{ route('login') }}">Войдите</a>
        </div>
    </div>
</div>
@endsection