<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [ArticlesController::class, 'index'])->name('home');
Route::get('/articles/create', [ArticlesController::class, 'create'])->name('articles.create')->middleware('auth');
Route::post('/articles', [ArticlesController::class, 'store'])->name('articles.store')->middleware('auth');
Route::get('/my-articles', [ArticlesController::class, 'mine'])->name('articles.mine')->middleware('auth');
Route::get('/articles/{article}/edit', [ArticlesController::class, 'edit'])->name('articles.edit')->middleware('auth');
Route::put('/articles/{article}', [ArticlesController::class, 'update'])->name('articles.update')->middleware('auth');
Route::delete('/articles/{article}', [ArticlesController::class, 'destroy'])->name('articles.destroy')->middleware('auth');
Route::get('/articles/{article}', [ArticlesController::class, 'show'])->name('articles.show');

Route::post('/articles/{article}/like', [ArticlesController::class, 'like'])->name('articles.like')->middleware('auth');

// التعليقات
Route::post('/articles/{article}/comments', [CommentsController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/comments/{comment}/reply', [CommentsController::class, 'reply'])->name('comments.reply')->middleware('auth');
Route::delete('/comments/{comment}', [CommentsController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

Auth::routes();