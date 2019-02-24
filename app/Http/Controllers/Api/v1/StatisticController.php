<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\Set;
use App\Models\Setable;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;

class StatisticController extends Controller
{
    public function index()
    {
        $countFn = function ($cardClass) {
            return $cardClass::count();
        };

        $setCardsCountFn = function ($cardClass) {
            return Setable::whereSetableType($cardClass)->count();
        };

        return response()->json([
            'total_numbers_of_unique_cards' => $this->getCardsFor($countFn),
            'number_of_sets' => Set::count(),
            'number_of_set_cards' => $this->getCardsFor($setCardsCountFn),
        ]);
    }

    private function getCardsFor($operatorFn)
    {
        $monsterCards = $operatorFn(MonsterCard::class);
        $ritualMonsterCards = $operatorFn(RitualMonsterCard::class);
        $linkMonsterCards = $operatorFn(LinkMonsterCard::class);
        $synchroMonsterCards = $operatorFn(SynchroMonsterCard::class);
        $xyzMonsterCards = $operatorFn(XyzMonsterCard::class);
        $pendulumMonsterCards = $operatorFn(PendulumMonsterCard::class);
        $spellCards = $operatorFn(SpellCard::class);
        $trapCards = $operatorFn(TrapCard::class);

        return compact(
            'monsterCards',
            'ritualMonsterCards',
            'linkMonsterCards',
            'synchroMonsterCards',
            'xyzMonsterCards',
            'pendulumMonsterCards',
            'spellCards',
            'trapCards'
        );
    }
}
