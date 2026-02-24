@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Добро пожаловать, {{ $user->name }}!</h4>
                    <p class="card-text">Это ваш личный кабинет. Здесь вы можете управлять своим профилем.</p>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Информация о профиле</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Имя</label>
                            <p class="fw-bold">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Фамилия</label>
                            <p class="fw-bold">{{ $user->surname }}</p>
                        </div>
<div class="col-md-6 mb-3">
                            <label class="text-muted">Логин</label>
                            <p class="fw-bold">{{ $user->login }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Email</label>
                            <p class="fw-bold">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted">Дата регистрации</label>
                            <p class="fw-bold">{{ $user->created_at->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row mt-4">
                <div class="col-12">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 py-3">
                            <i class="fas fa-sign-out-alt me-2"></i> Выйти из аккаунта
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection