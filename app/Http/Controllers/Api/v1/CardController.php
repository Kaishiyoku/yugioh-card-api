<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index()
    {
        $allMonsterCards = DB::table('all_monster_cards')->get();

        return response()->json($allMonsterCards);
    }

    public function search($title)
    {
        $allMonsterCards = DB::table('all_monster_cards')
            ->where('title_german', 'LIKE', '%' . $title . '%')
            ->orWhere('title_english', 'LIKE', '%' . $title . '%')
            ->get()
        ;

        return response()->json($allMonsterCards);
    }
}
