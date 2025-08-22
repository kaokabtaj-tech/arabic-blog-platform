@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top rounded" alt="صورة المقال" style="height: 300px; object-fit:cover;">
                @endif
                <div class="card-body">
                    <h2 class="card-title text-primary">{{ $article->title }}</h2>
                    <p>{{ $article->description }}</p>
                </div>
                <div class="card-footer bg-light">
                    <span class="badge bg-primary">{{ $article->category->name }}</span>
                    <span class="badge bg-info">المعلقون: {{ $article->comments_count }}</span>
                    <span class="badge bg-success">الإعجابات: {{ $article->likes_count }}</span>
                    
                    <!-- زر الإعجاب -->
                    <form action="{{ route('articles.like', $article->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm ms-2">إعجاب</button>
                    </form>
                    
                    <!-- عرض أسماء المعجبين -->
                    <div class="mt-2">
                        <strong>المعجبون:</strong>
                        @forelse($article->likes as $user)
                            <span>{{ $user->name }}</span>@if(!$loop->last), @endif
                        @empty
                            <span>لا يوجد معجبين بعد</span>
                        @endforelse
                    </div>
                    
                    <div class="mt-2 text-muted small">
                        الكاتب: {{ $article->user->name }} | تاريخ النشر:
                        {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('Y-m-d') : '-' }}
                    </div>
                </div>
            </div>

            {{-- نموذج إضافة تعليق --}}
            <div class="card mt-4">
                <div class="card-header">إضافة تعليق جديد</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store', $article->id) }}">
                        @csrf
                        <textarea name="content" class="form-control" placeholder="أضف تعليقك هنا..." required></textarea>
                        <button type="submit" class="btn btn-success mt-2">إرسال التعليق</button>
                    </form>
                </div>
            </div>

            {{-- عرض التعليقات --}}
            <div class="card mt-4">
                <div class="card-header">التعليقات</div>
                <div class="card-body">
                    @forelse($article->comments as $comment)
                        <div class="mb-2 border-bottom pb-2">
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="text-muted small">({{ $comment->created_at->format('Y-m-d H:i') }})</span>
                            <p>{{ $comment->content }}</p>
                        </div>
                    @empty
                        <div class="text-muted">لا توجد تعليقات بعد.</div>
                    @endforelse
                </div>
            </div>

            {{-- زر العودة --}}
            <a href="{{ route('home') }}" class="btn btn-secondary mt-3">عودة</a>
        </div>
    </div>
</div>
@endsection