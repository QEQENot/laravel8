@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            
            <div class="card mb-4">
                <img src="{{ $news->image }}" class="card-img-top" alt="{{ $news->title }}" style="max-height: 400px; object-fit: cover;">
                <div class="card-body">
                    <h1 class="card-title">{{ $news->title }}</h1>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="badge bg-primary">{{ $news->category_name }}</span>
                            <span class="text-muted ms-2">
                                <i class="far fa-calendar-alt"></i> {{ date('d.m.Y', strtotime($news->created_at)) }}
                            </span>
                        </div>
                        <div>
                            <span class="text-muted">
                                <i class="far fa-eye"></i> {{ $views ?? $news->views }} просмотров
                            </span>
                            @if(isset($avg_rating) && $avg_rating)
                                <span class="ms-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($avg_rating))
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <span class="text-muted">({{ number_format($avg_rating, 1) }})</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if($news->excerpt)
                    <p class="lead">{{ $news->excerpt }}</p>
                    <hr>
                    @endif
                    
                    <div class="news-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                    
                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i> Автор: {{ $news->author_name }}
                        </small>
                    </div>
                </div>
            </div>
            
            
            @if(isset($related_news) && count($related_news) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Похожие новости</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($related_news as $related)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="{{ $related->image }}" class="card-img-top" alt="{{ $related->title }}" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h6 class="card-title">
                                        <a href="/news/{{ $related->id }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($related->title, 50) }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            
            <div class="card">
                <div class="card-header">
                    <h5>Отзывы ({{ isset($comments) ? count($comments) : 0 }})</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    
                    <div class="mb-4">
                        <h6>Оставить отзыв</h6>
                        <form method="POST" action="{{ route('news.comment', $news->id) }}">
                            @csrf
                            
                            @guest
                            <div class="mb-3">
                                <label class="form-label">Ваше имя</label>
                                <input type="text" name="user_name" class="form-control" required>
                            </div>
                            @endguest
                            
                            <div class="mb-3">
                                <label class="form-label">Оценка</label>
                                <select name="rating" class="form-control" required>
                                    <option value="5">5 - Отлично</option>
                                    <option value="4">4 - Хорошо</option>
                                    <option value="3">3 - Нормально</option>
                                    <option value="2">2 - Плохо</option>
                                    <option value="1">1 - Ужасно</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ваш отзыв</label>
                                <textarea name="comment" class="form-control" rows="3" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Отправить
                            </button>
                        </form>
                    </div>
                    
                    <hr>
                    
                    
                    @if(isset($comments) && count($comments) > 0)
                        @foreach($comments as $comment)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $comment->user_name }}</strong>
                                    <small class="text-muted ms-2">{{ date('d.m.Y H:i', strtotime($comment->created_at)) }}</small>
                                </div>
                                @auth
                                    @if(Auth::user()->role == 2)
                                        <form method="POST" action="{{ route('comment.delete', $comment->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Удалить отзыв?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            <div class="mb-2 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $comment->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="mb-0">{{ $comment->comment }}</p>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">Пока нет отзывов. Будьте первым!</p>
                    @endif
                </div>
            </div>
        </div>
        
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Информация</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-folder me-2"></i> Категория: {{ $news->category_name }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar me-2"></i> Дата: {{ date('d.m.Y', strtotime($news->created_at)) }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-eye me-2"></i> Просмотров: {{ $views ?? $news->views }}
                        </li>
                        @if(isset($avg_rating))
                        <li class="mb-2">
                            <i class="fas fa-star me-2"></i> Рейтинг: {{ number_format($avg_rating ?? 0, 1) }}/5
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection