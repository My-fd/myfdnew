@extends('admin.base')

@section('title', 'Список атрибутов')

@section('content')
    <h1>Список атрибутов</h1>
    <a href="{{ route('admin.attributes.create') }}" class="btn btn-success">Добавить атрибут</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Тип</th>
            <th>Опции</th>
            <th>Комментарий</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attributes as $attribute)
            <tr>
                <td>{{ $attribute->id }}</td>
                <td>{{ $attribute->name }}</td>
                <td>{{ $attribute->type }}</td>
                <td>
                    @if(is_array($attribute->options))
                        <ul>
                            @foreach($attribute->options as $option)
                                <li>{{ $option }}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>{{ $attribute->comment }}</td>
                <td>
                    <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                    <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этот атрибут?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
