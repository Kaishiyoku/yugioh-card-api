<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;

class CardController extends Controller
{
    public function index()
    {
        $monsterCards = $this->orderByTitle(MonsterCard::class)->get();
        $pendulumMonsterCards = $this->orderByTitle(PendulumMonsterCard::class)->get();
        $linkMonsterCards = $this->orderByTitle(LinkMonsterCard::class)->get();
        $synchroMonsterCards = $this->orderByTitle(SynchroMonsterCard::class)->get();
        $cyzMonsterCards = $this->orderByTitle(XyzMonsterCard::class)->get();
        $ritualMonsterCards = $this->orderByTitle(RitualMonsterCard::class)->get();
        $spellCards = $this->orderByTitle(SpellCard::class)->get();
        $trapCards = $this->orderByTitle(TrapCard::class)->get();

        return response()->json(compact('monsterCards', 'pendulumMonsterCards', 'linkMonsterCards', 'synchroMonsterCards', 'cyzMonsterCards', 'ritualMonsterCards', 'spellCards', 'trapCards'));
    }

    private function orderByTitle($model)
    {
        return $model::orderBy('title_english')->orderBy('title_german');
    }
}
