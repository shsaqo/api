<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentItemFile extends Model
{
    use HasFactory;
    protected $fillable = ['comment_item_image'];
}
