<?php

namespace App\Jobs;

use App\Entities\CardSet;
use App\Entities\SetCard;
use App\Models\Set;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSetCard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var SetCard
     */
    protected $setCard;

    /**
     * Create a new job instance.
     *
     * @param SetCard $setCard
     */
    public function __construct(SetCard $setCard)
    {
        $this->setCard = $setCard;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cardCarrier = fetchCard($this->setCard->getAttribute(), $this->setCard->getCardInfo(), $this->setCard->getUrl());
        $card = $cardCarrier->getCard();
        $cardSets = $cardCarrier->getCardSets();

        $className = get_class($card);
        $foundCard = $className::whereTitleGerman($card->title_german)->whereTitleEnglish($card->title_english)->first();

        if (empty($foundCard)) {
            $card->save();
        } else {
            $foundCard->fill($card->toArray());

            $foundCard->save();
            $card = $foundCard;
        }

        $cardSets->each(function (CardSet $cardSet) use ($card) {
            $foundSet = Set::whereIdentifier($cardSet->getSetIdentifier())->first();

            if (empty($foundSet)) {
                $set = new Set();
                $set->identifier = $cardSet->getSetIdentifier();

                $set = $this->setLocalizedTitle($cardSet, $set);

                $set->save();

                $this->attachCardToSet($card, $set, $cardSet);
            } else {
                $foundSet = $this->setLocalizedTitle($cardSet, $foundSet);

                $foundSet->save();

                $this->attachCardToSet($card, $foundSet, $cardSet);
            }
        });
    }

    private function attachCardToSet($card, Set $set, CardSet $cardSet)
    {
        $card->sets()->attach($set, ['identifier' => $cardSet->getCardIdentifier(), 'rarity' => $cardSet->getRarity()]);
    }

    /**
     * @param CardSet $cardSet
     * @param Set $set
     * @return Set
     */
    private function setLocalizedTitle(CardSet $cardSet, Set $set)
    {
        if ($cardSet->getLang() == 'de') {
            $set->title_german = $cardSet->getTitle();
        } else if ($cardSet->getLang() == 'en') {
            $set->title_english = $cardSet->getTitle();
        }

        return $set;
    }
}
