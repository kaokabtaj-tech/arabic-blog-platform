@extends('layouts.app')

@section('title', 'إنشاء مقالة جديدة')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white fw-bold">إنشاء مقالة جديدة</div>
        <div class="card-body">
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- اسم المقالة -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">اسم المقالة</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- وصف المقالة -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">وصف المقالة</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- اختيار القسم -->
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">القسم</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">اختر القسم</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- إرفاق صورة -->
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">صورة المقالة (اختياري)</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <!-- زر الحفظ -->
                <button type="submit" class="btn btn-success px-5">حفظ المقالة</button>
            </form>
        </div>
    </div>
</div>
@endsection