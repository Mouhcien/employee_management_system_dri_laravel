<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function occupation() {
        return $this->belongsTo(Occupation::class);
    }

}
