<?php

namespace App\Console\Commands;

use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;
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
        $this->testXyzMonsterCard();
        $this->testLinkMonsterCard();
        $this->testSynchroMonsterCard();
        $this->testRitualMonsterCard();
        $this->testSpellCard();
        $this->testTrapCard();

        $this->info('');
    }

    private function testNormalMonsterCard()
    {
        $expectedMonsterCard = new MonsterCard();
        $expectedMonsterCard->title_german = 'Blauäugiger w. Drache';
        $expectedMonsterCard->title_english = 'Blue-Eyes White Dragon';
        $expectedMonsterCard->attribute = 'LIGHT';
        $expectedMonsterCard->level = 8;
        $expectedMonsterCard->monster_type = 'Dragon';
        $expectedMonsterCard->card_type = 'Normal';
        $expectedMonsterCard->atk = '3000';
        $expectedMonsterCard->def = '2500';
        $expectedMonsterCard->card_text_german = 'Dieser legendäre Drache ist eine mächtige Zerstörungsmaschine. Er ist buchstäblich unbesiegbar, nur wenige haben diese Furcht einflößende Kreatur gesehen und lange genug gelebt, um davon zu berichten.';
        $expectedMonsterCard->card_text_english = 'This legendary dragon is a powerful engine of destruction. Virtually invincible, very few have faced this awesome creature and lived to tell the tale.';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=4007';

        $actualMonsterCard = fetchCard('MONSTER', null, 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=4007');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Normal monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Normal monster card crawling succeeded.');
        }
    }

    private function testEffectMonsterCard()
    {
        $expectedMonsterCard = new MonsterCard();
        $expectedMonsterCard->title_german = 'Gefahr! Ogopogo!';
        $expectedMonsterCard->title_english = 'Danger! Ogopogo!';
        $expectedMonsterCard->attribute = 'DARK';
        $expectedMonsterCard->level = 8;
        $expectedMonsterCard->monster_type = 'Sea Serpent';
        $expectedMonsterCard->card_type = 'Effect';
        $expectedMonsterCard->atk = '1200';
        $expectedMonsterCard->def = '3000';
        $expectedMonsterCard->card_text_german = 'Du kannst diese Karte in deiner Hand vorzeigen; dein Gegner bestimmt zufällig 1 Karte von deiner gesamten Hand, dann wirfst du die bestimmte Karte ab. Dann, falls die abgeworfene Karte nicht „Gefahr! Ogopogo!“ war, beschwöre 1 „Gefahr! Ogopogo!“ als Spezialbeschwörung von deiner Hand und falls du dies tust, ziehe 1 Karte. Falls diese Karte abgeworfen wird: Du kannst 1 „Gefahr!“-Karte von deinem Deck auf den Friedhof legen, außer „Gefahr! Ogopogo!“. Du kannst diesen Effekt von „Gefahr! Ogopogo!“ nur einmal pro Spielzug verwenden.';
        $expectedMonsterCard->card_text_english = 'You can reveal this card in your hand; your opponent randomly chooses 1 card from your entire hand, then you discard the chosen card. Then, if the discarded card was not "Danger! Ogopogo!", Special Summon 1 "Danger! Ogopogo!" from your hand, and if you do, draw 1 card. If this card is discarded: You can send 1 "Danger!" card from your Deck to the GY, except "Danger! Ogopogo!". You can only use this effect of "Danger! Ogopogo!" once per turn.';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351';

        $actualMonsterCard = fetchCard('MONSTER', null, 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Effect monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Effect monster card crawling succeeded.');
        }
    }

    private function testPendulumMonsterCard()
    {
        $expectedMonsterCard = new PendulumMonsterCard();
        $expectedMonsterCard->title_german = 'Astrografzauberer';
        $expectedMonsterCard->title_english = 'Astrograph Sorcerer';
        $expectedMonsterCard->attribute = 'DARK';
        $expectedMonsterCard->level = 7;
        $expectedMonsterCard->pendulum_scale = 1;
        $expectedMonsterCard->pendulum_effect_german = 'Während deiner Main Phase: Du kannst diese Karte zerstören und falls du dies tust, nimm 1 „Sterndeutender Magier“ von deiner Hand oder deinem Deck und lege ihn entweder in deine Pendelzone oder beschwöre ihn als Spezialbeschwörung. Du kannst diesen Effekt von „Astrografzauberer“ nur einmal pro Spielzug verwenden.';
        $expectedMonsterCard->pendulum_effect_english = 'During your Main Phase: You can destroy this card, and if you do, take 1 "Stargazer Magician" from your hand or Deck, and either place it in your Pendulum Zone or Special Summon it. You can only use this effect of "Astrograph Sorcerer" once per turn.';
        $expectedMonsterCard->monster_type = 'Spellcaster';
        $expectedMonsterCard->card_type = 'Pendulum/Effect';
        $expectedMonsterCard->atk = '2500';
        $expectedMonsterCard->def = '2000';
        $expectedMonsterCard->card_text_german = 'Falls eine oder mehr Karten, die du kontrollierst, durch Kampf oder einen Karteneffekt zerstört werden: Du kannst diese Karte als Spezialbeschwörung von deiner Hand beschwören, dann kannst du 1 Monster im Friedhof, im Extra Deck oder das verbannt ist, und das in diesem Spielzug zerstört wurde, bestimmen und deiner Hand 1 Monster mit demselben Namen von deinem Deck hinzufügen. Du kannst diese Karte, die du kontrollierst, plus 4 Monster von deiner Hand, deiner Spielfeldseite und/oder deinem Friedhof (jeweils 1 mit „Pendeldrache“, „Xyz-Drache“, „Synchrodrache“ und „Fusionsdrache“ in ihren Namen) verbannen; beschwöre 1 „Oberster König Z-ARC“ als Spezialbeschwörung von deinem Extra Deck. (Dies wird als Fusionsbeschwörung behandelt.)';
        $expectedMonsterCard->card_text_english = 'If a card(s) you control is destroyed by battle or card effect: You can Special Summon this card from your hand, then you can choose 1 monster in the Graveyard, Extra Deck, or that is banished, and that was destroyed this turn, and add 1 monster with the same name from your Deck to your hand. You can banish this card you control, plus 4 monsters from your hand, field, and/or Graveyard (1 each with "Pendulum Dragon", "Xyz Dragon", "Synchro Dragon", and "Fusion Dragon" in their names); Special Summon 1 "Supreme King Z-ARC" from your Extra Deck. (This is treated as a Fusion Summon.)';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=12906';

        $actualMonsterCard = fetchCard('MONSTER', '[Spellcaster/Pendulum/Effect]', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=12906');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Pendulum monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Pendulum monster card crawling succeeded.');
        }
    }

    private function testXyzMonsterCard()
    {
        $expectedMonsterCard = new XyzMonsterCard();
        $expectedMonsterCard->title_german = 'Abyss-Bewohner';
        $expectedMonsterCard->title_english = 'Abyss Dweller';
        $expectedMonsterCard->attribute = 'WATER';
        $expectedMonsterCard->rank = 4;
        $expectedMonsterCard->monster_type = 'Sea Serpent';
        $expectedMonsterCard->card_type = 'Xyz/Effect';
        $expectedMonsterCard->atk = '1700';
        $expectedMonsterCard->def = '1400';
        $expectedMonsterCard->card_text_german = '2 Monster der Stufe 4Solange an diese Karte ein Xyz-Material angehängt ist, das ursprünglich WASSER war, erhalten alle WASSER Monster, die du kontrollierst, 500 ATK. Einmal pro Spielzug, während des Spielzugs eines beliebigen Spielers: Du kannst 1 Xyz-Material von dieser Karte abhängen; Karteneffekte, die im Friedhof deines Gegners aktiviert werden, können in diesem Spielzug nicht aktiviert werden.';
        $expectedMonsterCard->card_text_english = '2 Level 4 monstersWhile this card has an Xyz Material attached that was originally WATER, all WATER monsters you control gain 500 ATK. Once per turn, during either player\'s turn: You can detach 1 Xyz Material from this card; any card effects that activate in your opponent\'s Graveyard cannot be activated this turn.';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=10354';

        $actualMonsterCard = fetchCard('MONSTER', '[Xyz/Effect]', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=10354');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Xyz monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Xyz monster card crawling succeeded.');
        }
    }

    private function testSynchroMonsterCard()
    {
        $expectedMonsterCard = new SynchroMonsterCard();
        $expectedMonsterCard->title_german = 'Schnellsynchron';
        $expectedMonsterCard->title_english = 'Accel Synchron';
        $expectedMonsterCard->attribute = 'DARK';
        $expectedMonsterCard->level = 5;
        $expectedMonsterCard->monster_type = 'Machine';
        $expectedMonsterCard->card_type = 'Synchro/Tuner/Effect';
        $expectedMonsterCard->atk = '500';
        $expectedMonsterCard->def = '2100';
        $expectedMonsterCard->card_text_german = '1 Empfänger- + 1 oder mehr Nicht-Empfänger-MonsterEinmal pro Spielzug: Du kannst 1 „Synchron“-Monster von deinem Deck auf den Friedhof legen und dann 1 dieser Effekte aktivieren;●Erhöhe die Stufe dieser Karte um die Stufe des auf den Friedhof gelegten Monsters.●Verringere die Stufe dieser Karte um die Stufe des auf den Friedhof gelegten Monsters.Während der Main Phase deines Gegners kannst du: Sofort nachdem dieser Effekt aufgelöst wurde, beschwöre 1 Synchromonster als Synchrobeschwörung und verwende dabei Material, das du kontrollierst, einschließlich dieser Karte. (Dies ist ein Schnelleffekt.) Du kannst nur einmal pro Spielzug ein oder mehr „Schnellsynchron“ als Synchrobeschwörung beschwören.';
        $expectedMonsterCard->card_text_english = '1 Tuner + 1 or more non-Tuner monstersOnce per turn: You can send 1 "Synchron" monster from your Deck to the Graveyard, then activate 1 of these effects;●Increase this card\'s Level by the Level of the sent monster.●Reduce this card\'s Level by the Level of the sent monster.During your opponent\'s Main Phase, you can: Immediately after this effect resolves, Synchro Summon 1 Synchro Monster, using Materials including this card you control (this is a Quick Effect). You can only Synchro Summon "Accel Synchron(s)" once per turn.';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=11629';

        $actualMonsterCard = fetchCard('MONSTER', '[Machine/Synchro/Tuner/Effect]', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=11629');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Synchro monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Synchro monster card crawling succeeded.');
        }
    }

    private function testRitualMonsterCard()
    {
        $expectedMonsterCard = new RitualMonsterCard();
        $expectedMonsterCard->title_german = 'Aufgegeben';
        $expectedMonsterCard->title_english = 'Relinquished';
        $expectedMonsterCard->attribute = 'DARK';
        $expectedMonsterCard->level = 1;
        $expectedMonsterCard->monster_type = 'Spellcaster';
        $expectedMonsterCard->card_type = 'Ritual/Effect';
        $expectedMonsterCard->atk = '0';
        $expectedMonsterCard->def = '0';
        $expectedMonsterCard->card_text_german = 'Du kannst diese Karte mit „Schwarze-Illusion-Ritual“ als Ritualbeschwörung beschwören. Einmal pro Spielzug: Du kannst 1 Monster wählen, das dein Gegner kontrolliert; rüste diese Karte mit dem gewählten Ziel aus (max. 1). Die ATK/DEF dieser Karte werden dieselben wie die des ausrüstenden Monsters. Falls diese Karte durch Kampf zerstört würde, zerstöre stattdessen das ausrüstende Monster. Solange diese Karte mit dem Monster ausgerüstet ist, fügt jeglicher Kampfschaden, den du aus Kämpfen erhältst, an denen diese Karte beteiligt ist, deinem Gegner genauso viel Effektschaden zu.';
        $expectedMonsterCard->card_text_english = 'You can Ritual Summon this card with "Black Illusion Ritual". Once per turn: You can target 1 monster your opponent controls; equip that target to this card (max. 1). This card\'s ATK/DEF become equal to that equipped monster\'s. If this card would be destroyed by battle, destroy that equipped monster instead. While equipped with that monster, any battle damage you take from battles involving this card inflicts equal effect damage to your opponent.';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=4737';

        $actualMonsterCard = fetchCard('MONSTER', '[Spellcaster/Ritual/Effect]', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=4737');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Ritual monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Ritual monster card crawling succeeded.');
        }
    }

    private function testLinkMonsterCard()
    {
        $expectedMonsterCard = new LinkMonsterCard();
        $expectedMonsterCard->title_german = 'Dekodier-Sprecher';
        $expectedMonsterCard->title_english = 'Decode Talker';
        $expectedMonsterCard->attribute = 'DARK';
        $expectedMonsterCard->link = 3;
        $expectedMonsterCard->monster_type = 'Cyberse';
        $expectedMonsterCard->card_type = 'Link/Effect';
        $expectedMonsterCard->atk = '2300';
        $expectedMonsterCard->def = '-';
        $expectedMonsterCard->card_text_german = '2+ EffektmonsterDiese Karte erhält 500 ATK für jedes Monster, auf das sie zeigt. Wenn dein Gegner eine Karte oder einen Effekt aktiviert, die oder der eine oder mehr Karten, die du kontrollierst, als Ziel wählt (Schnelleffekt): Du kannst 1 Monster, auf das diese Karte zeigt, als Tribut anbieten; annulliere die Aktivierung und falls du dies tust, zerstöre die Karte.';
        $expectedMonsterCard->card_text_english = '2+ Effect MonstersGains 500 ATK for each monster it points to. When your opponent activates a card or effect that targets a card(s) you control (Quick Effect): You can Tribute 1 monster this card points to; negate the activation, and if you do, destroy that card.';
        $expectedMonsterCard->url = 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=13036';

        $actualMonsterCard = fetchCard('MONSTER', '[Cyberse/Link/Effect]', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=13036');

        $differ = new MapDiffer();
        $monsterCardDiff = $differ->doDiff($expectedMonsterCard->toArray(), $actualMonsterCard->toArray());

        if (count($monsterCardDiff) > 0 || !isSameClass($expectedMonsterCard, $actualMonsterCard)) {
            $this->error('-> Link monster card crawling failed:');
            $this->error(var_dump($monsterCardDiff));
        } else {
            $this->info('-> Link monster card crawling succeeded.');
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

        if (count($spellCardDiff) > 0 || !isSameClass($expectedSpellCard, $actualSpellCard)) {
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

        if (count($trapCardDiff) > 0 || !isSameClass($expectedTrapCard, $actualTrapCard)) {
            $this->error('-> Trap card crawling failed:');
            $this->error(var_dump($trapCardDiff));
        } else {
            $this->info('-> Trap card crawling succeeded.');
        }
    }
}