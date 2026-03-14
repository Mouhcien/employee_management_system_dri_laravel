<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function chef() {
        return $this->belongsTo(Chef::class);
    }
}
