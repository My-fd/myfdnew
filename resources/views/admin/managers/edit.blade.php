<?php /** @var \App\Models\Role[] $roles */ ?>
<?php /** @var \App\Models\Manager $manager */ ?>
@extends('admin.base')

@section('title', "Роли пользователей")

@section('content')
    <h2>Менеджер {{ $manager->surname . ' ' . $manager->name }}</h2>
    <hr>
    <form action="{{ route('admin.managers.update', $manager) }}" method="post">
        @csrf
        <fieldset class="form-group">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Роли</legend>
                <div class="col-sm-10">
                    @foreach($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="role[{{ $role->id }}]"
                                   id="role{{ $role->id }}" {{ $manager->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role{{ $role->id }}">
                                {{ $role->description }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </fieldset>
        <button class="btn btn-sm btn-primary">Сохранить</button>
    </form>
@endsection
