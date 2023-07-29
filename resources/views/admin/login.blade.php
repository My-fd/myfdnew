@extends('admin.base')

@section('title')
    Авторизация
@endsection

@section('root')
    <div class="card col col-md-6 offset-3 mt-15">
        <div class="card-header">Авторизация</div>
        <div class="card-body">
            <form class="row g-3 needs-validation" method="post" action="{{ route('admin.auth') }}">
                @csrf
                @method('post')
                <div class="mb-3">
                    <label class="form-label" for="email">Логин</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="email@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="*******">
                </div>
                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-sign-in-alt"></i> Войти
                </button>
            </form>
        </div>
    </div>
@endsection
