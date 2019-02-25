<?php

namespace App\Jobs;

use App\Entities\SetCard;
use App\Entities\SetLink;
use App\Helpers\CrawlHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSetLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var SetLink
     */
    protected $setLink;

    /**
     * Create a new job instance.
     *
     * @param string $baseUrl
     * @param SetLink $setLink
     */
    public function __construct($baseUrl, SetLink $setLink)
    {
        $this->baseUrl = $baseUrl;
        $this->setLink = $setLink;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $setCards = CrawlHelper::fetchSetCards($this->baseUrl, $this->setLink->getUrl());

        $setCards->each(function (SetCard $item) {
            ProcessSetCard::dispatch($item);
        });
    }
}
