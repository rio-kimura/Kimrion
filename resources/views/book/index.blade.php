@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <h2>書籍検索</h2>

    <div style="margin-bottom: 30px; text-align: center;">
        <form action="{{ route('books.index') }}" method="GET">
            <input type="text" name="keyword" value="{{ $keyword }}" placeholder="書籍名・著者名で検索" style="padding: 10px; width: 60%; font-size: 16px;">
            <button type="submit" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">検索</button>
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2; border-bottom: 2px solid #ddd;">
                <th style="padding: 15px; text-align: left; width: 60%;">タイトル</th>
                <th style="padding: 15px; text-align: left; width: 40%;">著者</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>
                        {{-- タイトル --}}
                        <a href="{{ route('books.read', $book->id) }}" style="text-decoration: none; color: #007BFF; font-weight: bold;">
                            {{ $book->title }}
                        </a>
                    </td>
                    <td>
                        {{-- 【重要】ここを修正 --}}
                        {{-- 誤: $book->author --}}
                        {{-- 正: $book->author->name --}}
                        {{ $book->author->name ?? '不明' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center;">該当する書籍は見つかりませんでした。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
