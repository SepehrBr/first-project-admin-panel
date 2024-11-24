<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Discount\Entities\Discount;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'view_count',
        'description',
        'inventory',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }


    // polymorphic relation with comments
    public function comments()
    {
        /*
                to use this method first of all in controller in creating comment code blocks, we should create basics of this relation:

        auth()->user()->comments()->create([
            'comment' => 'this is comment',
            'commentable_id' => $product->id,
            'commentable_type' => get_class($product)
        ]);


        other method is by using user_id =>
        $product->comments()->create([
            'user_id' => auth()->user()->id,
            'comment' => 'comment 2 by using user_id method'
        ]);
        */
        return $this->morphMany(Comment::class, 'commentable');
    }
}
