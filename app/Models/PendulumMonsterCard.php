<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PendulumMonsterCard
 *
 * @property int $id
 * @property string $title_german
 * @property string $title_english
 * @property string $attribute
 * @property int $level
 * @property int $pendulum_scale
 * @property string $pendulum_effect_german
 * @property string $pendulum_effect_english
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereAtk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereDef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereMonsterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard wherePendulumEffectEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard wherePendulumEffectGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard wherePendulumScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereUrl($value)
 * @mixin \Eloquent
 * @property bool $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereIsForbidden($value)
 * @property bool $is_limited
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PendulumMonsterCard whereIsLimited($value)
 */
class PendulumMonsterCard extends Model
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
        'additional_text_german',
        'additional_text_english',
        'additional_value',
        'is_forbidden',
        'is_limited',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_forbidden' => 'boolean',
        'is_limited' => 'boolean',
    ];

    public function sets()
    {
        return $this->morphToMany(Set::class, 'setable');
    }
}
