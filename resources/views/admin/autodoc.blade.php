@extends('admin.base')

@section('title', 'Документация')

@section('content')

    <rapi-doc
        id="doc"
        sort-tags="true"
        goto-path="post-/login"
        allow-spec-url-load="false"
        allow-spec-file-load="false"
        allow-server-selection="false"
        show-header="false"
        regular-font="'Frutiger', 'Frutiger Linotype', 'Tahoma', 'Helvetica', 'sans-serif'"
        spec-url="{{ route('admin.specification') }}">
    </rapi-doc>

    <script src="{{ asset('/assets/js/rapidoc.min.js') }}"></script>
@endsection
