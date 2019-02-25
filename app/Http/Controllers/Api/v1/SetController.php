<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AllMonsterCard;
use App\Models\Set;

class SetController extends Controller
{
    public function index()
    {
        $sets = Set::orderBy('identifier')->get();

        return response()->json($sets);
    }

    public function show($identifier)
    {
        $set = Set::whereIdentifier($identifier)->first();

        return response()->json($set);
    }

    public function search($term)
    {
        $sets = Set::where('title_german', 'LIKE', '%' . $term . '%')
            ->orWhere('title_english', 'LIKE', '%' . $term . '%')
            ->orWhere('identifier', $term)
            ->with([
                'monsterCards',
                'pendulumMonsterCards',
                'xyzMonsterCards',
                'synchroMonsterCards',
                'linkMonsterCards',
                'ritualMonsterCards',
                'spellCards',
                'trapCards'
            ])
            ->get()
        ;

        return response()->json($sets);
    }
}
