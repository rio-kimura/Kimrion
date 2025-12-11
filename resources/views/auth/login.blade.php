@extends('layouts.app')
@section('title', 'ログインページ')

@section('content')
    <h2>ログイン</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

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
            <label for="password">パスワード</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                required
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                ログイン
            </button>
        </div>

        <div class="auth-links">
            <a href="{{ route('register') }}">アカウントをお持ちでない方はこちら</a>
        </div>
    </form>
@endsection