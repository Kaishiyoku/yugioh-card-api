<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\XyzMonsterCard
 *
 * @property int $id
 * @property string $title_german
 * @property string $title_english
 * @property string $attribute
 * @property int $rank
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereAtk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereDef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereMonsterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereUrl($value)
 * @mixin \Eloquent
 * @property bool $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereIsForbidden($value)
 * @property bool $is_limited
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\XyzMonsterCard whereIsLimited($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FailedCardImageCrawling[] $failedCardImageCrawlings
 */
class XyzMonsterCard extends Model
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
        'rank',
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
