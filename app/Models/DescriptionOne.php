<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescriptionOne extends Model
{
    use HasFactory;
    protected $fillable = ['description_one_type', 'description_one_name', 'description_one_image'];

    public function description()
    {
        return $this->hasMany(DescriptionOneItem::class);
    }
}
