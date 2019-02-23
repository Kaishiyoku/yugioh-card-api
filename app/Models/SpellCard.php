<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpellCard
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Set[] $sets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title_german
 * @property string $title_english
 * @property string $icon
 * @property string $card_text_german
 * @property string $card_text_english
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereCardTextEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereCardTextGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereTitleGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereUpdatedAt($value)
 * @property string $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereUrl($value)
 * @property int $is_forbidden
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereIsForbidden($value)
 * @property bool $is_limited
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpellCard whereIsLimited($value)
 */
class SpellCard extends Model
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
}
