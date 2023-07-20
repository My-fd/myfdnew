@extends('web.base')

@section('content')
    @parent <!-- Содержимое из web.blade.php будет подключено в этом месте -->

    <!-- Дополнительный контент из listings.blade.php будет добавлен после содержимого из web.blade.php -->
    @include('web.listings.listings')
@endsection
