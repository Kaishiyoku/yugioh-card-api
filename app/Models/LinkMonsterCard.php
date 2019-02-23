<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LinkMonsterCard
 *
 * @property int $id
 * @property string $title_german
 * @property string $title_english
 * @property string $attribute
 * @property int $link
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereAtk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereDef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereMonsterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereUrl($value)
 * @mixin \Eloquent
 * @property bool $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereIsForbidden($value)
 * @property bool $is_limited
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkMonsterCard whereIsLimited($value)
 */
class LinkMonsterCard extends Model
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
        'link',
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
}
