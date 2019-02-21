<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrapCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_german',
        'title_english',
        'icon',
        'card_text_german',
        'card_text_english',
    ];

    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
