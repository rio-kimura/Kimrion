@extends('layouts.app')

@section('title', 'トップページ')

@section('content')
    <h2>トップページ</h2>
    <p>ここは文庫サイトのメインページです。</p>

    <div class="card">
        <div class="card-header">
            人気ランキング
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">順位</th>
                        <th scope="col">タイトル</th>
                        <th scope="col">著者</th>
                        <th scope="col">閲覧数</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse でデータがある場合とない場合を分岐 --}}
                    @forelse ($rankingBooks as $book)
                        <tr>
                            {{-- $loop->iteration で 1, 2, 3... という連番（順位）を表示 --}}
                            <th scope="row">{{ $loop->iteration }}位</th>

                            {{-- タイトル --}}
                            <td>{{ $book->title }}</td>

                            {{-- 著者名（著者が削除されている場合のケアとして ?? を使用） --}}
                            <td>{{ $book->author->name ?? '不明な著者' }}</td>

                            {{-- 閲覧数 --}}
                            <td>{{ $book->view_count }} PV</td>
                        </tr>
                    @empty
                        {{-- データが1件もない場合の表示 --}}
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
