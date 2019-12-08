<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Similar extends Model
{

    public function movie() {
        return $this->belongsToMany(Movie::class);
    }
}
