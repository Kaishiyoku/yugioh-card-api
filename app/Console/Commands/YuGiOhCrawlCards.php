<?php

namespace App\Console\Commands;

use App\Entities\SetCard;
use App\Entities\SetLink;
use App\Models\MonsterCard;
use App\Models\SpellCard;
use App\Models\TrapCard;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class YuGiOhCrawlCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yugioh:crawl {setName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl and save all Yu-Gi-Oh! cards';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $baseUrl = 'https://www.db.yugioh-card.com';
        $setName = $this->argument('setName');

        $setLinks = fetchAllSetLinks($baseUrl);

        if (!empty($setName)) {
            $setLinks = $setLinks->filter(function (SetLink $item) use ($setName) {
                return $item->getTitle() == Str::upper($setName);
            });
        }

        $setLinks->each(function (SetLink $item) use ($baseUrl) {
            $this->info('crawling set "' . $item->getTitle() . '"');

            $setCards = fetchSetCards($baseUrl, $item->getUrl());

            $cards = $setCards->map(function (SetCard $item) {
                return fetchCard($item->getAttribute(), $item->getUrl(), $this);
            });

            $cards->each(function ($item) {
                $className = get_class($item);
                $foundCard = $className::whereTitleGerman($item->title_german)->whereTitleEnglish($item->title_english)->first();

                if (empty($foundCard)) {
                    $item->save();
                } else {
                    $foundCard->fill($item->toArray());

                    $foundCard->save();
                }
            });
        });
    }
}
