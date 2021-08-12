<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentItem extends Model
{
    use HasFactory;
    protected $fillable = ['comment_text', 'comment_name', 'comment_user_image', 'comment_time'];

    public function commentItemFile()
    {
        return $this->hasMany(CommentItemFile::class);
    }
}
