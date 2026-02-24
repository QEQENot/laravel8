@extends('layouts.app')

@section('title', 'Настройки')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Настройки главной страницы</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Заголовок блока новостей</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Заголовок</label>
                            <input type="text" name="news_title" class="form-control" value="{{ $news_header->title ?? 'Последние новости' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Подзаголовок</label>
                            <input type="text" name="news_subtitle" class="form-control" value="{{ $news_header->subtitle ?? 'Самые свежие события из мира автомобилей' }}">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Сохранить
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Кнопка "Все новости"</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Текст кнопки</label>
                            <input type="text" name="button_text" class="form-control" value="{{ $all_news_button->button_text ?? 'Все новости' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ссылка</label>
                            <input type="text" name="button_link" class="form-control" value="{{ $all_news_button->button_link ?? '/news' }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Сохранить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection