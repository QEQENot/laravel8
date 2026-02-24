@extends('layouts.app')

@section('title', 'Редактирование новости')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Редактирование новости</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.news.update', $news->id) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Заголовок</label>
                            <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" value="{{ $news->slug }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category_id" class="form-control">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $news->category_id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Путь к картинке</label>
                            <input type="text" name="image" class="form-control" value="{{ $news->image }}" required>
                            <small class="text-muted">Например: /assets/image/news1.jpg</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Краткое описание</label>
                            <textarea name="excerpt" class="form-control" rows="3">{{ $news->excerpt }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Полный текст</label>
                            <textarea name="content" class="form-control" rows="6" required>{{ $news->content }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news') }}" class="btn btn-secondary">Назад</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection