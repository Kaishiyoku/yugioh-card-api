<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Helpers\ArrHelper;
use App\Helpers\CommonHelper;
use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class YuGiOhCrawlCardImages extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yugioh:crawl_images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl and save all Yu-Gi-Oh! card images';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cardClasses = [
            MonsterCard::class,
            RitualMonsterCard::class,
            LinkMonsterCard::class,
            SynchroMonsterCard::class,
            XyzMonsterCard::class,
            PendulumMonsterCard::class,
            SpellCard::class,
            TrapCard::class
        ];

        ArrHelper::each(function ($cardClass) {
            $this->fetchCardImagesFor($cardClass);
        }, $cardClasses);
    }

    private function fetchCardImagesFor($cardClass)
    {
        $baseUrl = 'https://yugioh.fandom.com/wiki';
        $cardType = Str::plural(str_replace('_card', '', Str::snake(last(explode('\\', $cardClass)))));

        $cards = $cardClass::all();

        $converter = new CssSelectorConverter();

        $cards->each(function (Model $card) use ($baseUrl, $converter, $cardType) {
            $html = CommonHelper::getExternalContent($this->fetchCardUrl($card));

            $crawler = new Crawler($html);

            try {
                $imageUrl = $crawler->filterXPath($converter->toXPath('td.cardtable-cardimage img'))->attr('src');

                Storage::disk('local')->put('/card_images/' . $cardType . '/' . Str::slug($card->title_english) . '.jpg', CommonHelper::getExternalContent($imageUrl));

                $this->info('Crawled image for card ' . Str::singular($cardType) . '-' . $card->id . ' "' . $card->title_english . '"');
            } catch (\Exception $e) {
                $errorMessage = 'Can\'t fetch image for card ' . Str::singular($cardType) . '-' . $card->id . ' "' . $card->title_english . '"';
                $this->error($errorMessage);
                Log::error($errorMessage);
            }
        });
    }

    private function fetchCardUrl(Model $card)
    {
        $queryHtml = CommonHelper::getExternalContent('https://yugioh.fandom.com/wiki/Special:Search?query=' . urlencode($card->title_english));

        $queryCrawler = new Crawler($queryHtml);
        $converter = new CssSelectorConverter();

        return $queryCrawler->filterXPath($converter->toXPath('ul.Results > li.result a'))->first()->attr('href');
    }
}
