@extends('admin.base')

@section('title', "Создание категории")

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создание категории') }}</div>

                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <div class="form-group">
                                <label for="title">{{ __('Название') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="title" name="name"
                                       placeholder="{{ __('Важное') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">{{ __('Изображение') }}</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="parent_id">{{ __('Родительская категория') }}</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">Без родительской категории</option>
                                    @foreach(App\Models\Category::all() as $parentCategory)
                                        <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="attributes">Атрибуты</label>
                                <select multiple class="form-control" id="attributes" name="attributes[]">
                                    @foreach($allAttributes as $attribute)
                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success float-right">{{ __('Добавить') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
