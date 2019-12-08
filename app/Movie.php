<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = "movies";

    public function qualities() {
        return $this->hasMany(Quality::class);
    }

    public function similars() {
        return $this->hasMany(Similar::class);
    }
}
