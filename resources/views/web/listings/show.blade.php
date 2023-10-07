@extends('web.base')

@section('title', $listing->title)

@section('content')
    <div class="container">
        <h1>{{ $listing->title }}</h1>
        <p>{{ $listing->description }}</p>
        <p>Цена: {{ $listing->price }}</p>
        <p>Категория: {{ $listing->category->name }}</p>
        <p>Город: {{ $listing->city }}</p>
        <p>Дата публикации: {{ $listing->created_at->format('d.m.Y') }}</p>

        @if($listing->photo_url)
            <img src="{{ $listing->photo_url }}" alt="{{ $listing->title }}" style="max-width: 400px;">
        @endif
    </div>
@endsection
