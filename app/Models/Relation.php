<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public function table() {
        return $this->belongsTo(Table::class);
    }

    public function column() {
        return $this->belongsTo(Column::class);
    }

}
