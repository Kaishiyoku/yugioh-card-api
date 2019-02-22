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
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index()
    {
        $allMonsterCards = DB::table('all_monster_cards')->get();

        return response()->json($allMonsterCards);
    }

    private function orderByTitle($model)
    {
        return $model::orderBy('title_english')->orderBy('title_german');
    }
}
