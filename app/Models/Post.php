<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'category_id', 'summary', 'featured_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function relatedPosts(){
        return $this->hasMany(Post::class,'category_id','category_id')->where('status','published')->orderBy('id','DESC')->limit(4);
    }

    public static function getPostBySlug($slug)
    {
        return Post::with(['relatedPosts', 'comments'])
            ->where('slug',$slug)
            ->first();
    }

}
