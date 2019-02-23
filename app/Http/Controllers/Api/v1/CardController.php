<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AllMonsterCard;

class CardController extends Controller
{
    public function index()
    {
        $allMonsterCards = AllMonsterCard::orderBy('title_german')
            ->orderBy('title_english')
            ->get()
        ;

        return response()->json($allMonsterCards);
    }

    public function search($title)
    {
        $allMonsterCards = AllMonsterCard::where('title_german', 'LIKE', '%' . $title . '%')
            ->orWhere('title_english', 'LIKE', '%' . $title . '%')
            ->get()
        ;

        return response()->json($allMonsterCards);
    }
}
