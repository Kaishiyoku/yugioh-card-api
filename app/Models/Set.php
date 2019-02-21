<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public function monsterCards()
    {
        return $this->morphedByMany(MonsterCard::class, 'setable');
    }

    public function spellCards()
    {
        return $this->morphedByMany(SpellCard::class, 'setable');
    }

    public function trapCards()
    {
        return $this->morphedByMany(TrapCard::class, 'setable');
    }
}
