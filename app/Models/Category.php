<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Get all posts in this category
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }

    /**
     * Get the route key for implicit model binding
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
