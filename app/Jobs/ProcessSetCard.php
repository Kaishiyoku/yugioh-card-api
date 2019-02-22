<?php

namespace App\Jobs;

use App\Entities\SetCard;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $card = fetchCard($this->setCard->getAttribute(), $this->setCard->getCardInfo(), $this->setCard->getUrl());

        $className = get_class($card);
        $foundCard = $className::whereTitleGerman($card->title_german)->whereTitleEnglish($card->title_english)->first();

        if (empty($foundCard)) {
            $card->save();
        } else {
            $foundCard->fill($card->toArray());

            $foundCard->save();
        }
    }
}
