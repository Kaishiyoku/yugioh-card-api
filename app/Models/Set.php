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
    ];

    public function monsterCards()
    {
        return $this->morphedByMany(MonsterCard::class, 'setable');
    }

    public function pendulumMonsterCards()
    {
        return $this->morphedByMany(PendulumMonsterCard::class, 'setable');
    }

    public function xyzMonsterCards()
    {
        return $this->morphedByMany(XyzMonsterCard::class, 'setable');
    }

    public function linkMonsterCards()
    {
        return $this->morphedByMany(LinkMonsterCard::class, 'setable');
    }

    public function spellCards()
    {
        return $this->morphedByMany(SpellCard::class, 'setable');
    }

    public function trapCards()
    {
        return $this->morphedByMany(TrapCard::class, 'setable');
    }
}
