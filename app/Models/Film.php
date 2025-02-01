<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'release_year', 'poster', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return number_format($this->reviews()->avg('point') ?? 0, 2);
    }

    public function casts()
    {
        return $this->belongsToMany(Cast::class, 'cast_film', 'film_id', 'cast_id')->withTimestamps();
    }
}
