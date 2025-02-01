<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age', 'bio', 'photo'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'cast_film', 'cast_id', 'film_id')->withTimestamps();
    }
}