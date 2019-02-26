<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MonsterCard
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Set[] $sets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard query()
 * @mixin \Eloquent
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereAtk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereDef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereMonsterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereUpdatedAt($value)
 * @property string $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereUrl($value)
 * @property string|null $additional_text_german
 * @property string|null $additional_text_english
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereAdditionalTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereAdditionalTextGerman($value)
 * @property string|null $additional_value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereAdditionalValue($value)
 * @property bool $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereIsForbidden($value)
 * @property bool $is_limited
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MonsterCard whereIsLimited($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FailedCardImageCrawling[] $failedCardImageCrawlings
 */
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
        'url',
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

    public function failedCardImageCrawlings()
    {
        return $this->morphMany(FailedCardImageCrawling::class, 'cardable');
    }
}
