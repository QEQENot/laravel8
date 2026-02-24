@extends('layouts.app')

@section('content')
<div class="container">
    
    
    <div id="carouselExampleCaptions" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($slider_settings as $key => $slide)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
            @endforeach
        </div>
        
        <div class="carousel-inner">
            @foreach($slider_settings as $key => $slide)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="3000">
                    <img src="{{ $slide->image }}" class="d-block w-100" alt="{{ $slide->title }}" style="height: 450px; object-fit: cover;">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h5 class="text-white">{{ $slide->title }}</h5>
                        <p class="text-white">{{ $slide->subtitle }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущий</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Следующий</span>
        </button>
    </div>

    
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">{{ $news_header->title ?? 'Последние новости' }}</h2>
            @if(isset($news_header->subtitle))
                <p class="text-muted">{{ $news_header->subtitle }}</p>
            @endif
        </div>
    </div>

    
    <div class="row g-4">
        @foreach($latest_news as $news)
        <div class="col-md-4">
            <div class="card h-100 news-card border-0 shadow-sm">
                <img src="{{ $news->image }}" class="card-img-top" alt="{{ $news->title }}" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <a href="/news/{{ $news->id }}" class="text-decoration-none text-dark fw-bold">
                            {{ $news->title }}
                        </a>
                    </h5>
                    <p class="text-muted small">{{ date('d.m.Y', strtotime($news->created_at)) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection

@push('styles')
<style>
    .news-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    }
    
    .news-card .card-img-top {
        transition: transform 0.5s;
        height: 200px;
        object-fit: cover;
    }
    
    .news-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .news-card .card-body {
        padding: 1.2rem;
    }
    
    .news-card .card-title a {
        font-size: 1.1rem;
        line-height: 1.4;
        display: block;
    }
    
    .news-card .card-title a:hover {
        color: #0d6efd !important;
    }
    
    .carousel-item {
        height: 450px;
    }
    
    .carousel-caption {
        bottom: 20%;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }
    
    .carousel-caption h5 {
        font-size: 2rem;
        font-weight: 700;
    }
    
    .carousel-caption p {
        font-size: 1.2rem;
    }
    
    @media (max-width: 768px) {
        .carousel-item {
            height: 300px;
        }
        
        .carousel-caption h5 {
            font-size: 1.3rem;
        }
        
        .carousel-caption p {
            font-size: 1rem;
        }
        
        .news-card .card-img-top {
            height: 180px;
        }
    }
</style>
@endpush