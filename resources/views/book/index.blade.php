@extends('layouts.layout')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <h2>書籍検索</h2>

    <div style="margin-bottom: 30px; text-align: center;">
        <form action="{{ route('book.index') }}" method="GET">
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
            @if(count($books) > 0)
                @foreach($books as $book)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 15px;">
                        <a href="{{ route('book.read', $book['id']) }}" style="text-decoration: none; color: #007BFF; font-weight: bold; display: block;">
                            {{ $book['title'] }}
                        </a>
                    </td>
                    <td style="padding: 15px;">
                        {{ $book['author'] }}
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" style="padding: 20px; text-align: center; color: #999;">
                        該当する書籍が見つかりませんでした。
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
