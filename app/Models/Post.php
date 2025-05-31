<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'thumbnail',
        'status'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    // app/Models/Post.php

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
