<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Helpers\ArrHelper;
use App\Helpers\CommonHelper;
use App\Jobs\ProcessCardImage;
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
        $cards = $cardClass::all();

        $cards->each(function (Model $card) {
            ProcessCardImage::dispatch($card);
        });
    }
}
