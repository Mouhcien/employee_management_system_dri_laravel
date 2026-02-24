<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function sector() {
        return $this->belongsTo(Sector::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }
}
