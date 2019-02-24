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
use Illuminate\Support\Str;

class CardController extends Controller
{
    public function index()
    {
        $withMapperAndOperations = function ($cardClass) {
            return $this->withCardSetMapper($this->withDefaultCardOperations($cardClass)->get());
        };

        $monsterCards = $withMapperAndOperations(MonsterCard::class);
        $ritualMonsterCards = $withMapperAndOperations(RitualMonsterCard::class);
        $linkMonsterCards = $withMapperAndOperations(LinkMonsterCard::class);
        $synchroMonsterCards = $withMapperAndOperations(SynchroMonsterCard::class);
        $xyzMonsterCards = $withMapperAndOperations(XyzMonsterCard::class);
        $pendulumMonsterCards = $withMapperAndOperations(PendulumMonsterCard::class);
        $spellCards = $withMapperAndOperations(SpellCard::class);
        $trapCards = $withMapperAndOperations(TrapCard::class);

        return response()->json(compact(
            'monsterCards',
            'ritualMonsterCards',
            'linkMonsterCards',
            'synchroMonsterCards',
            'xyzMonsterCards',
            'pendulumMonsterCards',
            'spellCards',
            'trapCards'
        ));
    }

    public function search($title)
    {
        $withMapperAndOperations = function ($cardClass, $title) {
            return $this->withCardSetMapper($this->withDefaultSearchOperations($cardClass, $title)->get());
        };

        $monsterCards = $withMapperAndOperations(MonsterCard::class, $title);
        $ritualMonsterCards = $withMapperAndOperations(RitualMonsterCard::class, $title);
        $linkMonsterCards = $withMapperAndOperations(LinkMonsterCard::class, $title);
        $synchroMonsterCards = $withMapperAndOperations(SynchroMonsterCard::class, $title);
        $xyzMonsterCards = $withMapperAndOperations(XyzMonsterCard::class, $title);
        $pendulumMonsterCards = $withMapperAndOperations(PendulumMonsterCard::class, $title);
        $spellCards = $withMapperAndOperations(SpellCard::class, $title);
        $trapCards = $withMapperAndOperations(TrapCard::class, $title);

        return response()->json(compact(
            'monsterCards',
            'ritualMonsterCards',
            'linkMonsterCards',
            'synchroMonsterCards',
            'xyzMonsterCards',
            'pendulumMonsterCards',
            'spellCards',
            'trapCards'
        ));
    }

    public function getCardFromSet($identifier)
    {
        if (!Str::contains($identifier, '-')) {
            return response()->json(new \stdClass());
        }

        list($setIdentifier, $cardIdentifier) = explode('-', $identifier);

        $set = Set::whereIdentifier($setIdentifier)->first();

        $cardSet = Setable::whereIdentifier($cardIdentifier)
            ->whereSetId($set->id)
            ->first();

        if (empty($cardSet)) {
            return response()->json(new \stdClass());
        }

        $card = $cardSet->setable_type::where('id', $cardSet->setable_id)->first();

        return response()->json([
            'set' => $set,
            'card_set' => $cardSet,
            'card' => $card,
        ]);
    }

    private function withDefaultCardOperations($cardClass)
    {
        return $cardClass::orderBy('title_german')
            ->orderBy('title_english');
    }

    private function withCardSetMapper($card)
    {
        return $card->map(function ($card) {
            return [
                'card' => $card,
                'card_sets' => Setable::whereSetableId($card->id)->whereSetableType(get_class($card))->get()->map(function ($setable) {
                    $set = Set::find($setable->set_id);

                    $setable->identifier = $set->identifier . '-' . $setable->identifier;

                    return $setable;
                }),
            ];
        });
    }

    private function withDefaultSearchOperations($cardClass, $title)
    {
        return $cardClass::where('title_german', 'LIKE', '%' . $title . '%')
            ->orWhere('title_english', 'LIKE', '%' . $title . '%');
    }
}
