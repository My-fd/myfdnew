@extends('web.base')

@section('title', 'Создать объявление')

@section('content')
    <div class="container">
        <h1>Создать объявление</h1>

        <form action="{{ route('web.listings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Цена</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select class="form-control" id="category" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

{{--            Тут надо форму загрузки множества изображений--}}
{{--            <div class="form-group">--}}
{{--                <label for="image">Изображения</label>--}}
{{--                <input type="file" class="form-control-file" id="image" name="image">--}}
{{--            </div>--}}

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection
