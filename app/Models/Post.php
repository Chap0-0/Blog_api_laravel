<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'description',
        'status'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function comments() : HasMany {
        return $this->hasMany(Comment::class);
    }

    public function likes() : BelongsToMany {
        return $this->belongsToMany(User::class, "post_user_likes");
    }

    public function tags() : BelongsToMany {
        return $this->belongsToMany(Tag::class, "post_tags");
    }
}
