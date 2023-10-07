<?php /** @var \App\Models\Category[] $categories */ ?>

@extends('admin.base')

@section('title', "Категории")

@section('content')
    <h2>Категории</h2>
    <hr>
    <div>
        <a href="{{ route('admin.categories.add') }}" class="btn btn-success btn-sm float-right">
            <i class="fas fa-plus-square"></i> Добавить категорию
        </a>
        <br><br>
    </div>
    <table class="table table-sm table-striped table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>
                    {{ $category->id }}
                </td>
                <td>{{ $category->name }}</td>
                <td>
                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" id="delete">
                        <a class="btn btn-sm btn-link" href="{{ route('admin.categories.edit', $category->id) }}">Редактировать</a>
                        @method('post')
                        @csrf
                        <button class="btn btn-sm btn-link"
                                onclick="return confirm('Вы точно хотите удалить категорию?')">Удалить
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="4">Список пуст</th>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $categories->links('admin.pagination.bootstrap-4') }}
@endsection
