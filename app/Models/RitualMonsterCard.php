<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RitualMonsterCard
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereAtk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereDef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereMonsterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereUrl($value)
 * @mixin \Eloquent
 * @property bool $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RitualMonsterCard whereIsForbidden($value)
 */
class RitualMonsterCard extends Model
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
        'is_forbidden',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_forbidden' => 'boolean',
    ];

    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
