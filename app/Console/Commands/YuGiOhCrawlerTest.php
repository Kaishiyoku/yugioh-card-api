<?php

namespace App\Console\Commands;

use Diff\Differ\MapDiffer;
use Illuminate\Console\Command;

class YuGiOhCrawlerTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yugioh:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the Yu-Gi-Oh! crawler';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $baseUrl = 'https://www.db.yugioh-card.com';

        $this->testInGerman($baseUrl);
        $this->testInEnglish($baseUrl);
    }

    private function testInGerman($baseUrl)
    {
        $actual = [
            'monsterCard' => fetchCard('MONSTER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351', 'de'),
            'spellCard' => fetchCard('ZAUBER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134', 'de'),
            'trapCard' => fetchCard('FALLE', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148', 'de'),
        ];

        $expected = [
            'monsterCard' => [
                'cardClass' => 'monster',
                'title' => 'Gefahr! Ogopogo!',
                'attribute' => 'FINSTERNIS',
                'level' => 8,
                'monsterType' => 'Seeschlange',
                'cardType' => 'Effekt',
                'atk' => '1200',
                'def' => '3000',
                'cardText' => 'Du kannst diese Karte in deiner Hand vorzeigen; dein Gegner bestimmt zufällig 1 Karte von deiner gesamten Hand, dann wirfst du die bestimmte Karte ab. Dann, falls die abgeworfene Karte nicht „Gefahr! Ogopogo!“ war, beschwöre 1 „Gefahr! Ogopogo!“ als Spezialbeschwörung von deiner Hand und falls du dies tust, ziehe 1 Karte. Falls diese Karte abgeworfen wird: Du kannst 1 „Gefahr!“-Karte von deinem Deck auf den Friedhof legen, außer „Gefahr! Ogopogo!“. Du kannst diesen Effekt von „Gefahr! Ogopogo!“ nur einmal pro Spielzug verwenden.',
            ],
            'spellCard' => [
                'cardClass' => 'spell',
                'title' => 'Fusion des Feuers',
                'icon' => 'Normales Zauber',
                'cardText' => '(Diese Karte wird immer als „Grosalamander“-Karte behandelt.)Beschwöre 1 „Grosalamander“-Fusionsmonster als Fusionsbeschwörung von deinem Extra Deck und verwende dafür Monster von deiner Hand und/oder einer beliebigen Spielfeldseite als Fusionsmaterial. Du kannst nur 1 „Fusion des Feuers“ pro Spielzug aktivieren.',
            ],
            'trapCard' => [
                'cardClass' => 'trap',
                'title' => 'NEXT',
                'icon' => 'Normales Fallen',
                'cardText' => 'Beschwöre eine beliebige Anzahl Monster mit unterschiedlichen Namen als Spezialbeschwörung von deiner Hand und/oder deinem Friedhof in die Verteidigungsposition, die alle „Neo-Weltraum“-Monster oder „Elementar-HELD Neos“ sind, aber annulliere ihre Effekte, und solange du welche der als Spezialbeschwörung beschworenen Monster offen kontrollierst, kannst du keine Monster als Spezialbeschwörung vom Extra Deck beschwören, außer Fusionsmonstern. Du kannst nur 1 „NEXT“ pro Spielzug aktivieren. Falls du keine Karten kontrollierst, kannst du diese Karte von deiner Hand aktivieren.',
            ],
        ];

        $this->test($baseUrl, 'de', $expected, $actual);
    }

    private function testInEnglish($baseUrl)
    {
        $actual = [
            'monsterCard' => fetchCard('MONSTER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351', 'en'),
            'spellCard' => fetchCard('SPELL', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134', 'en'),
            'trapCard' => fetchCard('TRAP', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148', 'en'),
        ];

        $expected = [
            'monsterCard' => [
                'cardClass' => 'monster',
                'title' => 'Danger! Ogopogo!',
                'attribute' => 'DARK',
                'level' => 8,
                'monsterType' => 'Sea Serpent',
                'cardType' => 'Effect',
                'atk' => '1200',
                'def' => '3000',
                'cardText' => 'You can reveal this card in your hand; your opponent randomly chooses 1 card from your entire hand, then you discard the chosen card. Then, if the discarded card was not "Danger! Ogopogo!", Special Summon 1 "Danger! Ogopogo!" from your hand, and if you do, draw 1 card. If this card is discarded: You can send 1 "Danger!" card from your Deck to the GY, except "Danger! Ogopogo!". You can only use this effect of "Danger! Ogopogo!" once per turn.',
            ],
            'spellCard' => [
                'cardClass' => 'spell',
                'title' => 'Fusion of Fire',
                'icon' => 'Normal Spell',
                'cardText' => '(This card is always treated as a "Salamangreat" card.)Fusion Summon 1 "Salamangreat" Fusion Monster from your Extra Deck, using monsters from your hand and/or either field as Fusion Material. You can only activate 1 "Fusion of Fire" per turn.',
            ],
            'trapCard' => [
                'cardClass' => 'trap',
                'title' => 'NEXT',
                'icon' => 'Normal Trap',
                'cardText' => 'Special Summon any number of monsters with different names from your hand and/or GY, in Defense Position, that are all "Neo-Spacian" monsters or "Elemental HERO Neos", but negate their effects, and as long as you control any of those Special Summoned monsters face-up, you cannot Special Summon monsters from the Extra Deck, except Fusion Monsters. You can only activate 1 "NEXT" per turn. If you control no cards, you can activate this card from your hand.',
            ]
        ];

        $this->test($baseUrl, 'en', $expected, $actual);
    }

    private function test($baseUrl, $lang, $expected, $actual)
    {
        $this->info('----- Lang: ' . $lang . ' -----');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expected['monsterCard'], $actual['monsterCard']);

        if (count($monsterCardDiff) > 0) {
            $this->error('-> Monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Monster card crawling succeeded.');
        }

        $spellCardDiff = $differ->doDiff($expected['spellCard'], $actual['spellCard']);

        if (count($spellCardDiff) > 0) {
            $this->error('-> Spell card crawling failed:');
            $this->error(var_dump($spellCardDiff));
        } else {
            $this->info('-> Spell card crawling succeeded.');
        }

        $trapCardDiff = $differ->doDiff($expected['trapCard'], $actual['trapCard']);

        if (count($trapCardDiff) > 0) {
            $this->error('-> Trap card crawling failed:');
            $this->error(var_dump($trapCardDiff));
        } else {
            $this->info('-> Trap card crawling succeeded.');
        }

        $this->info('');
    }
}