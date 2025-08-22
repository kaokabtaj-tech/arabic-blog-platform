@extends('layouts.app')

@section('title', 'منصة تدوين')

@section('content')
<div class="container mt-4">

    {{-- البحث والتصفية --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('home') }}" class="input-group">
                <input type="search" name="search" class="form-control" placeholder="بحث عن مقال..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">بحث</button>
            </form>
        </div>
        <div class="col-md-4">
            <select class="form-select" onchange="location = this.value;">
                <option value="{{ route('home') }}">جميع الأقسام</option>
                @foreach($categories as $category)
                    <option value="{{ route('home', ['category' => $category->id]) }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- في حال عدم وجود نتائج --}}
    @if($articles->count() == 0)
        <div class="alert alert-warning text-center mt-4">
            لا توجد نتائج مطابقة للبحث.
        </div>
    @endif

    {{-- عرض المقالات حسب الأقسام --}}
    @foreach($categories as $category)
        @php
            $categoryArticles = $articles->where('category_id', $category->id);
        @endphp
        @if($categoryArticles->count())
            <h3 class="mb-1 mt-3 text-primary">{{ $category->name }}</h3>
            <div class="row">
                @foreach($categoryArticles as $article)
                    <div class="col-md-4 mb-0">
                        <div class="card h-100 shadow">
                            {{-- صورة المقال --}}
                            @if($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top rounded" alt="صورة المقال" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="{{ asset('default-article.png') }}" class="card-img-top rounded" alt="بدون صورة" style="height: 180px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-primary">{{ $article->title }}</a>
                                </h5>
                                <p class="card-text">{{ Str::limit($article->description, 90) }}</p>
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-outline-primary btn-sm mt-2">عرض التفاصيل</a>
                                
                                {{-- زر الإعجاب --}}
                                <form method="POST" action="{{ route('articles.like', $article->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm mt-2">
                                        <i class="bi bi-hand-thumbs-up"></i> إعجاب ({{ $article->likes_count }})
                                    </button>
                                </form>
                                {{-- زر التعليقات --}}
                                <a href="{{ route('articles.show', $article) }}#comments" class="btn btn-outline-info btn-sm mt-2">
                                    <i class="bi bi-chat-dots"></i> التعليقات ({{ $article->comments_count }})
                                </a>
                            </div>
                            <div class="card-footer bg-light">
                                <span class="badge bg-primary">{{ $category->name }}</span>
                                <span class="badge bg-info">المعلقون: {{ $article->comments_count }}</span>
                                <span class="badge bg-success">الإعجابات: {{ $article->likes_count }}</span>
                                <div class="mt-2 text-muted small">
                                    الكاتب: {{ $article->user->name }} | تاريخ النشر:
                                    {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('Y-m-d') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    {{-- روابط الصفحات --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection