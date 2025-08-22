@extends('layouts.app')

@section('title', 'تعديل المقالة')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark fw-bold">تعديل المقالة</div>
        <div class="card-body">
            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- اسم المقالة -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">اسم المقالة</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $article->title) }}">
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- وصف المقالة -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">وصف المقالة</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $article->description) }}</textarea>
                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- اختيار القسم -->
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">القسم</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- إرفاق صورة جديدة -->
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">صورة المقالة (اختياري)</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" class="mt-2 rounded" width="100" height="100" alt="صورة المقالة">
                    @endif
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- زر الحفظ -->
                <button type="submit" class="btn btn-warning px-5">تعديل المقالة</button>
            </form>
        </div>
    </div>
</div>
@endsection