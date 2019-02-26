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
 */
class FailedCardImageCrawling extends Model
{
    public function cardable()
    {
        return $this->morphTo();
    }
}
