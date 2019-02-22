<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SynchroMonsterCard
 *
 * @property int $id
 * @property string $title_german
 * @property string $title_english
 * @property string $attribute
 * @property int $level
 * @property string $monster_type
 * @property string $card_type
 * @property string $atk
 * @property string $def
 * @property string $card_text_german
 * @property string $card_text_english
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Set[] $sets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereAtk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereDef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereMonsterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SynchroMonsterCard whereUrl($value)
 * @mixin \Eloquent
 */
class SynchroMonsterCard extends Model
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
        'url',
    ];

    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
