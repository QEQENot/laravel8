@extends('layouts.app')

@section('title', 'Управление новостями')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Управление новостями</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Добавить новость
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h5>Список новостей</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Категория</th>
                        <th>Дата</th>
                        <th>Просмотры</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @foreach($categories as $cat)
                                @if($cat->id == $item->category_id)
                                    {{ $cat->name }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ date('d.m.Y', strtotime($item->created_at)) }}</td>
                        <td>{{ $item->views }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Ред
                            </a>
                            <a href="{{ route('admin.news.delete', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Удалить новость?')">
                                <i class="fas fa-trash"></i> Уд
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection