<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilitation extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rule() {
        return $this->belongsTo(Rule::class);
    }
}
