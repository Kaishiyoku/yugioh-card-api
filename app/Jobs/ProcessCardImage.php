<?php

namespace App\Jobs;

use App\Helpers\CommonHelper;
use App\Models\FailedCardImageCrawling;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class ProcessCardImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $card;

    /**
     * Create a new job instance.
     *
     * @param Model $card
     * @return void
     */
    public function __construct(Model $card)
    {
        $this->card = $card;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cardType = Str::plural(str_replace('_card', '', Str::snake(last(explode('\\', get_class($this->card))))));
        $html = CommonHelper::getExternalContent(self::fetchCardUrl($this->card));

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        try {
            $imageUrl = $crawler->filterXPath($converter->toXPath('td.cardtable-cardimage img'))->attr('src');

            Storage::disk('local')->put('/card_images/' . $cardType . '/' . Str::slug($this->card->title_english) . '.jpg', CommonHelper::getExternalContent($imageUrl));
        } catch (\Exception $e) {
            $this->card->failedCardImageCrawlings()->save(new FailedCardImageCrawling());

            Log::error('Can\'t fetch image for card ' . Str::singular($cardType) . '-' . $this->card->id . ' "' . $this->card->title_english . '"');
        }
    }

    private static function fetchCardUrl(Model $card)
    {
        $queryHtml = CommonHelper::getExternalContent('https://yugioh.fandom.com/wiki/Special:Search?query=' . urlencode($card->title_english));

        $queryCrawler = new Crawler($queryHtml);
        $converter = new CssSelectorConverter();

        return $queryCrawler->filterXPath($converter->toXPath('ul.Results > li.result a'))->first()->attr('href');
    }
}
