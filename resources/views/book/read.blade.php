@extends('layouts.layout')

@section('content')
<div style="text-align: center; padding: 50px;">
    <h2>閲覧ページ</h2>
    <p>現在、書籍ID: <strong>{{ $id }}</strong> の本を開いています。</p>
    <p>ここに小説の本文が表示されます。</p>

    <div style="margin-top: 30px;">
        <a href="{{ route('book.index') }}">検索一覧に戻る</a>
    </div>
</div>
@endsection
