<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Product extends Model
{
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected $fillable = ['name', 'slug', 'image', 'price', 'description', 'cross_price', 'color'];
    // append image_url column
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        return $this->image ? url(Storage::url('images/products/' . $this->image)) : null;
    }
}
