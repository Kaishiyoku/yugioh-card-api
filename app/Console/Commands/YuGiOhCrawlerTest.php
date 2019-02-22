<?php

namespace App\Console\Commands;

use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
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
        $this->testNormalMonsterCard();
        $this->testEffectMonsterCard();
        $this->testPendulumMonsterCard();
        $this->testSpellCard();
        $this->testTrapCard();

        $this->info('');
    }

    private function testNormalMonsterCard()
    {
        $expectedNormalMonsterCard = new MonsterCard();
        $expectedNormalMonsterCard->title_german = 'Blauäugiger w. Drache';
        $expectedNormalMonsterCard->title_english = 'Blue-Eyes White Dragon';
        $expectedNormalMonsterCard->attribute = 'LIGHT';
        $expectedNormalMonsterCard->level = 8;
        $expectedNormalMonsterCard->monster_type = 'Dragon';
        $expectedNormalMonsterCard->card_type = 'Normal';
        $expectedNormalMonsterCard->atk = '3000';
        $expectedNormalMonsterCard->def = '2500';
        $expectedNormalMonsterCard->card_text_german = 'Dieser legendäre Drache ist eine mächtige Zerstörungsmaschine. Er ist buchstäblich unbesiegbar, nur wenige haben diese Furcht einflößende Kreatur gesehen und lange genug gelebt, um davon zu berichten.';
        $expectedNormalMonsterCard->card_text_english = 'This legendary dragon is a powerful engine of destruction. Virtually invincible, very few have faced this awesome creature and lived to tell the tale.';
        $expectedNormalMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=4007';

        $actualNormalMonsterCard = fetchCard('MONSTER', null, 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=4007');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedNormalMonsterCard->toArray(), $actualNormalMonsterCard->toArray());

        if (count($monsterCardDiff) > 0) {
            $this->error('-> Normal monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Normal monster card crawling succeeded.');
        }
    }

    private function testEffectMonsterCard()
    {
        $expectedEffectMonsterCard = new MonsterCard();
        $expectedEffectMonsterCard->title_german = 'Gefahr! Ogopogo!';
        $expectedEffectMonsterCard->title_english = 'Danger! Ogopogo!';
        $expectedEffectMonsterCard->attribute = 'DARK';
        $expectedEffectMonsterCard->level = 8;
        $expectedEffectMonsterCard->monster_type = 'Sea Serpent';
        $expectedEffectMonsterCard->card_type = 'Effect';
        $expectedEffectMonsterCard->atk = '1200';
        $expectedEffectMonsterCard->def = '3000';
        $expectedEffectMonsterCard->card_text_german = 'Du kannst diese Karte in deiner Hand vorzeigen; dein Gegner bestimmt zufällig 1 Karte von deiner gesamten Hand, dann wirfst du die bestimmte Karte ab. Dann, falls die abgeworfene Karte nicht „Gefahr! Ogopogo!“ war, beschwöre 1 „Gefahr! Ogopogo!“ als Spezialbeschwörung von deiner Hand und falls du dies tust, ziehe 1 Karte. Falls diese Karte abgeworfen wird: Du kannst 1 „Gefahr!“-Karte von deinem Deck auf den Friedhof legen, außer „Gefahr! Ogopogo!“. Du kannst diesen Effekt von „Gefahr! Ogopogo!“ nur einmal pro Spielzug verwenden.';
        $expectedEffectMonsterCard->card_text_english = 'You can reveal this card in your hand; your opponent randomly chooses 1 card from your entire hand, then you discard the chosen card. Then, if the discarded card was not "Danger! Ogopogo!", Special Summon 1 "Danger! Ogopogo!" from your hand, and if you do, draw 1 card. If this card is discarded: You can send 1 "Danger!" card from your Deck to the GY, except "Danger! Ogopogo!". You can only use this effect of "Danger! Ogopogo!" once per turn.';
        $expectedEffectMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351';

        $actualEffectMonsterCard = fetchCard('MONSTER', null, 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedEffectMonsterCard->toArray(), $actualEffectMonsterCard->toArray());

        if (count($monsterCardDiff) > 0) {
            $this->error('-> Effect monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Effect monster card crawling succeeded.');
        }
    }

    private function testPendulumMonsterCard()
    {
        $expectedPendulumMonsterCard = new PendulumMonsterCard();
        $expectedPendulumMonsterCard->title_german = 'Astrografzauberer';
        $expectedPendulumMonsterCard->title_english = 'Astrograph Sorcerer';
        $expectedPendulumMonsterCard->attribute = 'DARK';
        $expectedPendulumMonsterCard->level = 7;
        $expectedPendulumMonsterCard->pendulum_scale = 1;
        $expectedPendulumMonsterCard->pendulum_effect_german = 'Während deiner Main Phase: Du kannst diese Karte zerstören und falls du dies tust, nimm 1 „Sterndeutender Magier“ von deiner Hand oder deinem Deck und lege ihn entweder in deine Pendelzone oder beschwöre ihn als Spezialbeschwörung. Du kannst diesen Effekt von „Astrografzauberer“ nur einmal pro Spielzug verwenden.';
        $expectedPendulumMonsterCard->pendulum_effect_english = 'During your Main Phase: You can destroy this card, and if you do, take 1 "Stargazer Magician" from your hand or Deck, and either place it in your Pendulum Zone or Special Summon it. You can only use this effect of "Astrograph Sorcerer" once per turn.';
        $expectedPendulumMonsterCard->monster_type = 'Spellcaster';
        $expectedPendulumMonsterCard->card_type = 'Pendulum/Effect';
        $expectedPendulumMonsterCard->atk = '2500';
        $expectedPendulumMonsterCard->def = '2000';
        $expectedPendulumMonsterCard->card_text_german = 'Falls eine oder mehr Karten, die du kontrollierst, durch Kampf oder einen Karteneffekt zerstört werden: Du kannst diese Karte als Spezialbeschwörung von deiner Hand beschwören, dann kannst du 1 Monster im Friedhof, im Extra Deck oder das verbannt ist, und das in diesem Spielzug zerstört wurde, bestimmen und deiner Hand 1 Monster mit demselben Namen von deinem Deck hinzufügen. Du kannst diese Karte, die du kontrollierst, plus 4 Monster von deiner Hand, deiner Spielfeldseite und/oder deinem Friedhof (jeweils 1 mit „Pendeldrache“, „Xyz-Drache“, „Synchrodrache“ und „Fusionsdrache“ in ihren Namen) verbannen; beschwöre 1 „Oberster König Z-ARC“ als Spezialbeschwörung von deinem Extra Deck. (Dies wird als Fusionsbeschwörung behandelt.)';
        $expectedPendulumMonsterCard->card_text_english = 'If a card(s) you control is destroyed by battle or card effect: You can Special Summon this card from your hand, then you can choose 1 monster in the Graveyard, Extra Deck, or that is banished, and that was destroyed this turn, and add 1 monster with the same name from your Deck to your hand. You can banish this card you control, plus 4 monsters from your hand, field, and/or Graveyard (1 each with "Pendulum Dragon", "Xyz Dragon", "Synchro Dragon", and "Fusion Dragon" in their names); Special Summon 1 "Supreme King Z-ARC" from your Extra Deck. (This is treated as a Fusion Summon.)';
        $expectedPendulumMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=12906';

        $actualPendulumMonsterCard = fetchCard('MONSTER', '[Spellcaster/Pendulum/Effect]', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=12906');

        $differ = new MapDiffer();
        $pendulumMonsterCardDiff = $differ->doDiff($expectedPendulumMonsterCard->toArray(), $actualPendulumMonsterCard->toArray());

        if (count($pendulumMonsterCardDiff) > 0) {
            $this->error('-> Pendulum monster card crawling failed:');
            $this->error(var_dump($pendulumMonsterCardDiff));
        } else {
            $this->info('-> Pendulum monster card crawling succeeded.');
        }
    }

    private function testSpellCard()
    {
        $expectedSpellCard = new SpellCard();
        $expectedSpellCard->title_german = 'Fusion des Feuers';
        $expectedSpellCard->title_english = 'Fusion of Fire';
        $expectedSpellCard->icon = 'Normal Spell';
        $expectedSpellCard->card_text_german = '(Diese Karte wird immer als „Grosalamander“-Karte behandelt.)Beschwöre 1 „Grosalamander“-Fusionsmonster als Fusionsbeschwörung von deinem Extra Deck und verwende dafür Monster von deiner Hand und/oder einer beliebigen Spielfeldseite als Fusionsmaterial. Du kannst nur 1 „Fusion des Feuers“ pro Spielzug aktivieren.';
        $expectedSpellCard->card_text_english = '(This card is always treated as a "Salamangreat" card.)Fusion Summon 1 "Salamangreat" Fusion Monster from your Extra Deck, using monsters from your hand and/or either field as Fusion Material. You can only activate 1 "Fusion of Fire" per turn.';
        $expectedSpellCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134';

        $actualSpellCard = fetchCard('SPELL', null, 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134');

        $differ = new MapDiffer();
        $spellCardDiff = $differ->doDiff($expectedSpellCard->toArray(), $actualSpellCard->toArray());

        if (count($spellCardDiff) > 0) {
            $this->error('-> Spell card crawling failed:');
            $this->error(var_dump($spellCardDiff));
        } else {
            $this->info('-> Spell card crawling succeeded.');
        }
    }

    private function testTrapCard()
    {
        $expectedTrapCard = new TrapCard();
        $expectedTrapCard->title_german = 'NEXT';
        $expectedTrapCard->title_english = 'NEXT';
        $expectedTrapCard->icon = 'Normal Trap';
        $expectedTrapCard->card_text_german = 'Beschwöre eine beliebige Anzahl Monster mit unterschiedlichen Namen als Spezialbeschwörung von deiner Hand und/oder deinem Friedhof in die Verteidigungsposition, die alle „Neo-Weltraum“-Monster oder „Elementar-HELD Neos“ sind, aber annulliere ihre Effekte, und solange du welche der als Spezialbeschwörung beschworenen Monster offen kontrollierst, kannst du keine Monster als Spezialbeschwörung vom Extra Deck beschwören, außer Fusionsmonstern. Du kannst nur 1 „NEXT“ pro Spielzug aktivieren. Falls du keine Karten kontrollierst, kannst du diese Karte von deiner Hand aktivieren.';
        $expectedTrapCard->card_text_english = 'Special Summon any number of monsters with different names from your hand and/or GY, in Defense Position, that are all "Neo-Spacian" monsters or "Elemental HERO Neos", but negate their effects, and as long as you control any of those Special Summoned monsters face-up, you cannot Special Summon monsters from the Extra Deck, except Fusion Monsters. You can only activate 1 "NEXT" per turn. If you control no cards, you can activate this card from your hand.';
        $expectedTrapCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148';

        $actualTrapCard = fetchCard('TRAP', null, 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148');

        $differ = new MapDiffer();
        $trapCardDiff = $differ->doDiff($expectedTrapCard->toArray(), $actualTrapCard->toArray());

        if (count($trapCardDiff) > 0) {
            $this->error('-> Trap card crawling failed:');
            $this->error(var_dump($trapCardDiff));
        } else {
            $this->info('-> Trap card crawling succeeded.');
        }
    }
}