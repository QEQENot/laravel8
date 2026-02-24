@extends('layouts.app')

@section('title', 'Новости')

@section('content')
<div class="container py-4">

    <h1 class="fw-bold mb-4">Новости</h1>

    
    <div class="mb-4">
        <a href="{{ route('news') }}"
           class="btn btn-sm me-2 mb-2 {{ !$active_category ? 'btn-primary' : 'btn-outline-primary' }}">
            Все
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('news', ['category' => $cat->slug]) }}"
               class="btn btn-sm me-2 mb-2 {{ $active_category == $cat->slug ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    
    @if($news->count() > 0)
        <div class="row g-4">
            @foreach($news as $item)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm news-card">
                    <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->title }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">{{ $item->category_name }}</span>
                        <h5 class="card-title">
                            <a href="/news/{{ $item->id }}" class="text-decoration-none text-dark fw-bold">
                                {{ $item->title }}
                            </a>
                        </h5>
                        @if($item->excerpt)
                            <p class="text-muted small">{{ Str::limit($item->excerpt, 100) }}</p>
                        @endif
                        <small class="text-muted">{{ date('d.m.Y', strtotime($item->created_at)) }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        
        <div class="mt-4 d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    @else
        <div class="alert alert-info">В этой категории новостей нет.</div>
    @endif

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
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
    }
</style>
@endpush
