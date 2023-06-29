<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function designImages()
    {
        return $this->hasMany(Design_image::class);
    }
}
