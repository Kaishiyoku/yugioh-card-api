<?php

namespace App\Console\Commands;

use Diff\Differ\MapDiffer;
use Illuminate\Console\Command;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class TestYuGiOhCrawler extends Command
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
            'monsterCard' => $this->fetchCard('MONSTER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351', 'de'),
            'spellCard' => $this->fetchCard('ZAUBER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134', 'de'),
            'trapCard' => $this->fetchCard('FALLE', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148', 'de'),
        ];

        $expected = [
            'monsterCard' => [
                'cardClass' => 'monster',
                'title' => 'Gefahr! Ogopogo!',
                'attribute' => 'FINSTERNIS',
                'level' => 8,
                'monsterType' => 'Seeschlange',
                'cardType' => 'Effekt',
                'atk' => 1200,
                'def' => 3000,
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
            'monsterCard' => $this->fetchCard('MONSTER', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14351', 'en'),
            'spellCard' => $this->fetchCard('SPELL', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14134', 'en'),
            'trapCard' => $this->fetchCard('TRAP', 'https://www.db.yugioh-card.com/yugiohdb/card_search.action?ope=2&cid=14148', 'en'),
        ];

        $expected = [
            'monsterCard' => [
                'cardClass' => 'monster',
                'title' => 'Danger! Ogopogo!',
                'attribute' => 'DARK',
                'level' => 8,
                'monsterType' => 'Sea Serpent',
                'cardType' => 'Effect',
                'atk' => 1200,
                'def' => 3000,
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
            $this->error(print_r($monsterCardDiff));
        } else {
            $this->info('-> Monster card crawling succeeded.');
        }

        $spellCardDiff = $differ->doDiff($expected['spellCard'], $actual['spellCard']);

        if (count($spellCardDiff) > 0) {
            $this->error('-> Spell card crawling failed:');
            $this->error(print_r($spellCardDiff));
        } else {
            $this->info('-> Spell card crawling succeeded.');
        }

        $trapCardDiff = $differ->doDiff($expected['trapCard'], $actual['trapCard']);

        if (count($trapCardDiff) > 0) {
            $this->error('-> Trap card crawling failed:');
            $this->error(print_r($trapCardDiff));
        } else {
            $this->info('-> Trap card crawling succeeded.');
        }

        $this->info('');
    }

    private function fetchCard($attribute, $cardUrl, $lang)
    {
        $availableAttributes = [
            'de' => [
                'monster' => 'MONSTER',
                'spell' => 'ZAUBER',
                'trap' => 'FALLE',
            ],
            'en' => [
                'monster' => 'MONSTER',
                'spell' => 'SPELL',
                'trap' => 'TRAP',
            ],
        ];

        $attributes = $availableAttributes[$lang];

        if ($attribute == $attributes['spell']) {
            return $this->fetchSpell($cardUrl, $lang);
        } else if ($attribute == $attributes['trap']) {
            return $this->fetchTrap($cardUrl, $lang);
        } else {
            return $this->fetchMonster($cardUrl, $lang);
        }
    }

    private function fetchMonster($cardUrl, $lang)
    {
        $html = getExternalContent($cardUrl, $lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $tabularDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box > span.item_box_value'))->each(function (Crawler $node) {
            return trim($node->text());
        });
        $boxDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box_text, table#details div.item_box.t_center'))->each($this->childrenRemover());

        $cardClass = 'monster';
        $title = $crawler->filterXPath($converter->toXPath('nav#pan_nav > ul > li:nth-child(3)'))->text();
        $attribute = $tabularDetails[0];
        $level = intval($tabularDetails[1]);
        $monsterType = $boxDetails[0];
        $cardType = $boxDetails[1];
        $atk = intval($tabularDetails[2]);
        $def = intval($tabularDetails[3]);

        return compact('cardClass', 'title', 'attribute', 'level', 'monsterType', 'cardType', 'atk', 'def');
    }

    private function fetchSpell($cardUrl, $lang)
    {
        return array_merge(['cardClass' => 'spell'], $this->fetchSpellOrTrap($cardUrl, $lang));
    }

    private function fetchTrap($cardUrl, $lang)
    {
        return array_merge(['cardClass' => 'trap'], $this->fetchSpellOrTrap($cardUrl, $lang));
    }

    private function fetchSpellOrTrap($cardUrl, $lang)
    {
        $html = getExternalContent($cardUrl, $lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $tabularDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box'))->each($this->childrenRemover());
        $boxDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box_text'))->each($this->childrenRemover());

        $title = $crawler->filterXPath($converter->toXPath('nav#pan_nav > ul > li:nth-child(3)'))->text();
        $icon = $tabularDetails[0];
        $cardText = $boxDetails[0];

        return compact('title', 'icon', 'cardText');
    }

    private function fetchSetCards($baseUrl, $setUrl, $lang)
    {
        $html = getExternalContent($setUrl, $lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $setCards = $crawler->filterXPath($converter->toXPath('ul.box_list > li'))->each(function (Crawler $node) use ($baseUrl, $converter) {
            $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');
            $attribute = trim($node->filterXPath($converter->toXPath('dd.box_card_spec > span.box_card_attribute'))->text());

            return compact('url', 'attribute');
        });

        return $setCards;
    }

    private function fetchAllSetLinks($baseUrl, $lang)
    {
        $html = getExternalContent($baseUrl . '/yugiohdb/card_list.action',$lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $setLinks = $crawler->filterXPath($converter->toXPath('div#card_list_1 input.link_value[type=hidden]'))->each(function (Crawler $node) use ($baseUrl) {
            return $baseUrl . $node->attr('value');
        });

        return $setLinks;
    }

    private function childrenRemover()
    {
        return function (Crawler $node) {
            $domElement = $node->getNode(0);

            foreach ($node->children() as $child) {
                $domElement->removeChild($child);
            }

            return trim($node->text());
        };
    }
}