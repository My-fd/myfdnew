<?php /** @var \App\Models\Manager[] $managers */ ?>
@extends('admin.base')

@section('title', 'Менеджеры')

@section('content')
    <h2>Менеджеры</h2>
    <hr>
    <div>
        <a href="{{ route('admin.managers.add') }}" class="btn btn-success btn-sm float-right">
            <i class="fas fa-plus-square"></i> Добавить менеджера
        </a>
        <br><br>
    </div>
    @empty($managers)
        <h4>Список пуст</h4>
    @else
        <table class="table table-sm table-striped table-bordered table-hover table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">E-mail адрес</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($managers as $manager)
                <tr>
                    <th width="2%" scope="row">{{ $loop->iteration }}</th>
                    <td width="28%">{{ $manager->getFullName() }}</td>
                    <td width="20%">{{ $manager->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $managers->links('admin.pagination.bootstrap-4') }}
    @endempty
@endsection
