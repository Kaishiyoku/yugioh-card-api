<?php

namespace App\Console\Commands;

use App\Entities\SetLink;
use function App\helpers\fetchAllSetLinks;
use App\Jobs\ProcessSetLink;
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

            ProcessSetLink::dispatch($baseUrl, $item);
        });
    }
}
