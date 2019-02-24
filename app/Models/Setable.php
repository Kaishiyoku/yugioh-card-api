<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MichaelAChrisco\ReadOnly\ReadOnlyTrait;

/**
 * App\Models\Setable
 *
 * @property int $set_id
 * @property int $setable_id
 * @property string $setable_type
 * @property string $rarity
 * @property string $identifier
 * @property-read \App\Models\Set $set
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable whereRarity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable whereSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable whereSetableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setable whereSetableType($value)
 * @mixin \Eloquent
 */
class Setable extends Model
{
    use ReadOnlyTrait;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'set_id',
        'setable_id',
        'setable_type',
    ];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }
}
