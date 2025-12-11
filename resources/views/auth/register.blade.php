@extends('layouts.app')
@section('title', '新規登録')

@section('content')
    <h2>新規登録</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.confirm') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name">なまえ</label>
            <input 
                type="name" 
                name="name" 
                id="name" 
                class="form-control" 
                required
                autofocus
            >
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email') }}" 
                required 
                autofocus
            >
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード(2回入力)</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                required
            >
        </div>

        <div class="form-group">
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_conf" 
                class="form-control" 
                required
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                確認
            </button>
        </div>

        <div class="auth-links">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
    </form>
@endsection