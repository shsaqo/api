<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescriptionTwo extends Model
{
    use HasFactory;
    protected $fillable = ['description_two_type', 'description_two_name', 'description_two_image'];

    public function description()
    {
        return $this->hasMany(DescriptionTwoItem::class);
    }
}
