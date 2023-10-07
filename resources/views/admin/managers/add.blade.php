@extends('admin.base')

@section('title', 'Добавление менеджера')

@section('content')
    <div class="col col-10 offset-1">
        <form action="{{ route('admin.managers.store') }}" method="POST">
            @method('post')
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       placeholder="my-mail@example.org" value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname"
                       id="surname" placeholder="Ивонов" required value="{{ old('surname') }}">
                @error('surname')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                       placeholder="Иван" required value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="patronymic">Отчество</label>
                <input type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic"
                       id="patronymic" placeholder="Иванович" value="{{ old('patronymic') }}">
                @error('patronymic')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" name="password"
                       id="password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Подтвердите пароль</label>
                <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror"
                       name="password_confirmation" id="password_confirmation" required>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success float-right">Добавить</button>
        </form>
    </div>
@endsection
