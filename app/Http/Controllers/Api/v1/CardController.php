<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\MonsterCard;
use App\Models\SpellCard;
use App\Models\TrapCard;

class CardController extends Controller
{
    public function index()
    {
        $monsterCards = $this->orderByTitle(MonsterCard::class)->get();
        $spellCards = $this->orderByTitle(SpellCard::class)->get();
        $trapCards = $this->orderByTitle(TrapCard::class)->get();

        return response()->json(compact('monsterCards', 'spellCards', 'trapCards'));
    }

    private function orderByTitle($model)
    {
        return $model::orderBy('title_english')->orderBy('title_german');
    }
}
