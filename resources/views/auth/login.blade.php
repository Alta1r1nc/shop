@extends('layouts.app')

@section('content')
<div class="vhod_flex pb120">
    <div class="vhod">
        <p class="vhod_name pt60">Вход</p>
        <p class="vhod_text pb60">Мы ждали именно вас :)</p>
        <form action="{{ route('login') }}" method="POST" class="form_vhod">
            @csrf
            <input class="inp_vhod @error('email') error @enderror" name="email" type="text" placeholder="почта">
            @error('email')
                <p style="color: red">{{ $message }}</p>
            @enderror

            <input class="inp_vhod @error('password') error @enderror" name="password" type="password" placeholder="пароль">
            @error('password')
                <p style="color: red">{{ $message }}</p>
            @enderror

            @if (session('error'))
                <p style="color: red">{{ session('error') }}</p>
            @endif

            <button type="submit" class="vhod_btn">Войти</button>
        </form>
        <div class="net_acc">
            <p>Нет аккаунта?</p>
            <a href="{{ route('register') }}">Зарегистрируйтесь</a>
        </div>
    </div>
</div>
@endsection