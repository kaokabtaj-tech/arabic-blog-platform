@extends('layouts.app')

@section('title', 'مقالاتي')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">مقالاتي</h2>
        <a href="{{ route('articles.create') }}" class="btn btn-success">إنشاء مقالة جديدة</a>
    </div>
    <form class="mb-4" method="GET" action="{{ route('articles.mine') }}">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="بحث عن مقالتي ..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">بحث</button>
        </div>
    </form>
    @if($myArticles->count())
        @foreach($myArticles as $article)
        <div class="card mb-4 shadow">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    @if($article->image)
                        <img src="{{ asset('storage/'.$article->image) }}" class="rounded" width="70" height="70" alt="صورة المقالة">
                    @else
                        <span class="bg-secondary rounded-circle d-inline-block" style="width:70px;height:70px;"></span>
                    @endif
                    <div class="ms-3 flex-grow-1">
                        <h5 class="card-title mb-1">{{ $article->title }}</h5>
                        <small class="text-muted">
                            القسم: {{ $article->category->name }} | تاريخ النشر: {{ $article->published_at->format('Y-m-d') }}
                        </small>
                    </div>
                    <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-warning mx-1">تعديل</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mx-1" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                    </form>
                </div>
                <p class="card-text mt-2">{{ $article->description }}</p>
                <span class="badge bg-primary me-2">الإعجابات: {{ $article->likes_count }}</span>
                <span class="badge bg-info">التعليقات: {{ $article->comments_count }}</span>
            </div>
        </div>
        @endforeach
        {{ $myArticles->links() }}
    @else
        <div class="alert alert-info">لا توجد مقالات قمت بإنشائها بعد.</div>
    @endif
</div>
@endsection