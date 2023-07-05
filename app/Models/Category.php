<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'parent_category');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }


}
