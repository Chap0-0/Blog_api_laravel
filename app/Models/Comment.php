<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    public function post() : BelongsTo {
        return $this->belongsTo(Post::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
