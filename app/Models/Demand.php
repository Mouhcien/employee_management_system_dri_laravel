<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    public function mutation() {
        return $this->belongsTo(Mutation::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
