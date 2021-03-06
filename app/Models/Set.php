<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Set
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MonsterCard[] $monsterCards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SpellCard[] $spellCards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TrapCard[] $trapCards
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $identifier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LinkMonsterCard[] $linkMonsterCards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PendulumMonsterCard[] $pendulumMonsterCards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\XyzMonsterCard[] $xyzMonsterCards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SynchroMonsterCard[] $synchroMonsterCards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RitualMonsterCard[] $ritualMonsterCards
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereTitle($value)
 * @property string $title_german
 * @property string $title_english
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereTitleEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereTitleGerman($value)
 */
class Set extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'rarity',
        'title_german',
        'title_english',
    ];

    public function monsterCards()
    {
        return $this->morphedByMany(MonsterCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function pendulumMonsterCards()
    {
        return $this->morphedByMany(PendulumMonsterCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function xyzMonsterCards()
    {
        return $this->morphedByMany(XyzMonsterCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function synchroMonsterCards()
    {
        return $this->morphedByMany(SynchroMonsterCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function linkMonsterCards()
    {
        return $this->morphedByMany(LinkMonsterCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function ritualMonsterCards()
    {
        return $this->morphedByMany(RitualMonsterCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function spellCards()
    {
        return $this->morphedByMany(SpellCard::class, 'setable')->withPivot('rarity', 'identifier');
    }

    public function trapCards()
    {
        return $this->morphedByMany(TrapCard::class, 'setable')->withPivot('rarity', 'identifier');
    }
}
