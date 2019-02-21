<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonsterCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_german',
        'title_english',
        'attribute',
        'level',
        'monster_type',
        'card_type',
        'atk',
        'def',
        'card_text_german',
        'card_text_english',
    ];

    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
