<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TrapCard
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Set[] $sets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title_german
 * @property string $title_english
 * @property string $icon
 * @property string $card_text_german
 * @property string $card_text_english
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereUpdatedAt($value)
 * @property string $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereUrl($value)
 * @property int $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereIsForbidden($value)
 * @property bool $is_limited
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrapCard whereIsLimited($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FailedCardImageCrawling[] $failedCardImageCrawlings
 */
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
