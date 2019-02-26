<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FailedCardImageCrawling
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $cardable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $cardable_id
 * @property string $cardable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling whereCardableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling whereCardableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FailedCardImageCrawling whereUpdatedAt($value)
 */
class FailedCardImageCrawling extends Model
{
    public function cardable()
    {
        return $this->morphTo();
    }
}
