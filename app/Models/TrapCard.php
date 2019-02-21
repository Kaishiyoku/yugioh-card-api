<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrapCard extends Model
{
    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
