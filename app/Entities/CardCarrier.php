<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CardCarrier
{
    /**
     * @var Model
     */
    private $card;

    /**
     * @var Collection<CardSet>
     */
    private $cardSets;

    /**
     * @param Model $card
     * @param Collection<CardSet> $cardSets
     */
    public function __construct(Model $card, $cardSets)
    {
        $this->card = $card;
        $this->cardSets = $cardSets;
    }

    /**
     * @return Model
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @return Collection<CardSet>
     */
    public function getCardSets()
    {
        return $this->cardSets;
    }
}
