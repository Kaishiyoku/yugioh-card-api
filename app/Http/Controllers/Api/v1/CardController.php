<?php

namespace App\Http\Controllers\Api\v1;

use App\Entities\Card;
use App\Http\Controllers\Controller;
use App\Models\AllMonsterCard;
use App\Models\Set;
use App\Models\Setable;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class CardController extends Controller
{
    public function index()
    {
        $allMonsterCards = AllMonsterCard::orderBy('title_german')
            ->orderBy('title_english')
            ->get();

        return response()->json($allMonsterCards);
    }

    public function search($title)
    {
        $allMonsterCards = AllMonsterCard::where('title_german', 'LIKE', '%' . $title . '%')
            ->orWhere('title_english', 'LIKE', '%' . $title . '%')
            ->get();

        return response()->json($allMonsterCards);
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
            ->first()
        ;

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
}
