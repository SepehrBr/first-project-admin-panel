<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'parent'
    ];
    // table relations
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    // child relation methods
    public function child()
    {
        return $this->hasMany(Category::class, 'parent', 'id');
    }
}
