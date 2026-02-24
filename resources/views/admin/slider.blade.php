@extends('layouts.app')

@section('title', 'Управление слайдером')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Управление слайдером</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h5>Редактирование слайдов</h5>
        </div>
        <div class="card-body">
            @foreach($slider_settings as $slide)
            <div class="card mb-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.slider.update', $slide->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Заголовок</label>
                                <input type="text" name="title" class="form-control" value="{{ $slide->title }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Подзаголовок</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ $slide->subtitle }}">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Путь к картинке</label>
                                <input type="text" name="image" class="form-control" value="{{ $slide->image }}" required>
                                <small class="text-muted">/assets/image/название_файла.jpg</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Порядок</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ $slide->sort_order }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Активно</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $slide->is_active ? 'selected' : '' }}>Да</option>
                                    <option value="0" {{ !$slide->is_active ? 'selected' : '' }}>Нет</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Сохранить слайд
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection