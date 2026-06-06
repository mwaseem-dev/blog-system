<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Get all posts with this tag
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
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
