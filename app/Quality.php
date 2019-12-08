<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{

    protected $table = "qualities";

    public function movie() {
        return $this->belongsTo(Movie::class);
    }
}
