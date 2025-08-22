<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'description', 'category_id', 'user_id', 'image', 'published_at'];
    protected $casts = [
    'published_at' => 'datetime',
];
    protected $dates = ['published_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
       return $this->belongsToMany(\App\Models\User::class, 'article_user_likes');
    }
    
}