<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonsterCard extends Model
{
    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
