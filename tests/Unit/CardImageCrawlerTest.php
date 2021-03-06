<?php

namespace Tests\Unit;

use App\Entities\CardSet;
use App\Helpers\CrawlHelper;
use App\Jobs\ProcessCardImage;
use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class CardImageCrawlerTest extends TestCase
{
    use MatchesSnapshots;

    public function testAdjustCardTitleForImageFetching()
    {
        $expectedA = 'Harpie\'s Brother';
        $actualA = ProcessCardImage::adjustCardTitleForImageFetching('Sky Scout (Updated from: Harpie\'s Brother)');

        $this->assertEquals($expectedA, $actualA);

        $expectedB = 'Koumori Dragon';
        $actualB = ProcessCardImage::adjustCardTitleForImageFetching($expectedB);

        $this->assertEquals($expectedB, $actualB);
    }

    public function testAdjustCardTitleForImageFetchingSpecialCase()
    {
        $originalArr = [
            'Red Nova',
            'Lillybot',
            'Ancient Gear',
            'Pharaoh\'s Servant',
            'Princess Cologne',
            'Duelist Alliance',
            'Generation Force',
            'Dragunity Legion',
            'Cybernetic Revolution',
            'Return',
            'Labyrinth of Nightmare',
            'Light of Destruction',
            'Synchro Material',
        ];

        foreach ($originalArr as $key => $original) {
            $this->assertEquals("{$original} (card)", ProcessCardImage::adjustCardTitleForImageFetching($original));
        }
    }
}