<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'approved',
        'parent_id',
        'commentable_id',
        'commentable_type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function child()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');   // every comment has many child comments
    }

    public function commentable()
    {
        return $this->morphTo();
        /*
        now to use this unlike table ralations we dont add Model::class and instead it recognizes itself to what to do. instead we should do as below:

        $comment->commentable;
    or
        $comment->commentable();
        */
    }
}
