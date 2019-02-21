<?php

namespace App\Console\Commands;

use App\Models\MonsterCard;
use App\Models\SpellCard;
use App\Models\TrapCard;
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

        $test = $this->test($baseUrl);
    }

    private function test($baseUrl)
    {
        $monsterCard = new MonsterCard();
        $monsterCard->title_german = 'Gefahr! Ogopogo!';
        $monsterCard->title_english = 'Danger! Ogopogo!';
        $monsterCard->attribute = 'DARK';
        $monsterCard->level = 8;
        $monsterCard->monster_type = 'Sea Serpent';
        $monsterCard->card_type = 'Effect';
        $monsterCard->atk = '1200';
        $monsterCard->def = '3000';
        $monsterCard->card_text_german = 'Du kannst diese Karte in deiner Hand vorzeigen; dein Gegner bestimmt zufällig 1 Karte von deiner gesamten Hand, dann wirfst du die bestimmte Karte ab. Dann, falls die abgeworfene Karte nicht „Gefahr! Ogopogo!“ war, beschwöre 1 „Gefahr! Ogopogo!“ als Spezialbeschwörung von deiner Hand und falls du dies tust, ziehe 1 Karte. Falls diese Karte abgeworfen wird: Du kannst 1 „Gefahr!“-Karte von deinem Deck auf den Friedhof legen, außer „Gefahr! Ogopogo!“. Du kannst diesen Effekt von „Gefahr! Ogopogo!“ nur einmal pro Spielzug verwenden.';
        $monsterCard->card_text_english = 'You can reveal this card in your hand; your opponent randomly chooses 1 card from your entire hand, then you discard the chosen card. Then, if the discarded card was not "Danger! Ogopogo!", Special Summon 1 "Danger! Ogopogo!" from your hand, and if you do, draw 1 card. If this card is discarded: You can send 1 "Danger!" card from your Deck to the GY, except "Danger! Ogopogo!". You can only use this effect of "Danger! Ogopogo!" once per turn.';
        $monsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351';

        $spellCard = new SpellCard();
        $spellCard->title_german = 'Fusion des Feuers';
        $spellCard->title_english = 'Fusion of Fire';
        $spellCard->icon = 'Normal Spell';
        $spellCard->card_text_german = ''; // TODO
        $spellCard->card_text_english = 'Fusion of Fire'; // TODO
        $spellCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134';

        $trapCard = new TrapCard();
        $trapCard->title_german = 'NEXT';
        $trapCard->title_english = 'NEXT';
        $trapCard->icon = 'Normal Trap';
        $trapCard->card_text_german = ''; // TODO
        $trapCard->card_text_english = 'NEXT'; // TODO
        $trapCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148';

        $expected = [
            'monsterCard' => $monsterCard->toArray(),
            'spellCard' => $spellCard->toArray(),
            'trapCard' => $trapCard->toArray(),
        ];

        $actual = [
            'monsterCard' => fetchCard('MONSTER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351', $this)->toArray(),
            'spellCard' => fetchCard('SPELL', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134', $this)->toArray(),
            'trapCard' => fetchCard('TRAP', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148', $this)->toArray(),
        ];

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