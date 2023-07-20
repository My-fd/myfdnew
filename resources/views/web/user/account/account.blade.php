@extends('web.base')

@section('title', 'Личный кабинет')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Вставляем меню из отдельного шаблона -->
            @include('web.user.account.menu')
        </div>
        <div class="col-md-9">
            <!-- Аватар пользователя -->
            <div class="text-center mb-4">
                <img src="/path/to/avatar.jpg" alt="Avatar" class="rounded-circle" width="150">
                <h4 class="mt-2">Имя пользователя</h4>
            </div>

            <!-- Выводим объявления из отдельного шаблона -->
            @include('web.user.account.advertisements')
        </div>
    </div>
@endsection
