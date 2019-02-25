<?php

namespace App\Helpers;

use App\Entities\Card;
use App\Entities\CardCarrier;
use App\Entities\CardSet;
use App\Entities\LocaleSpecificCard;
use App\Entities\SetCard;
use App\Entities\SetLink;
use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;
use Illuminate\Support\Str;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class CrawlHelper
{
    /**
     * @return \Closure
     */
    public static function childrenRemover()
    {
        return function (Crawler $node) {
            $domElement = $node->getNode(0);

            foreach ($node->children() as $child) {
                $domElement->removeChild($child);
            }

            return trim($node->text());
        };
    }

    /**
     * @param string $baseUrl
     * @param string $lang
     * @return \Illuminate\Support\Collection
     */
    public static function fetchAllSetLinks($baseUrl, $lang = null)
    {
        $html = CommonHelper::getExternalContent($baseUrl . '/yugiohdb/card_list.action', $lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $setLinks = collect($crawler
            ->filterXPath($converter->toXPath('div#card_list_1 div.pack'))
            ->each(function (Crawler $node) use ($converter, $baseUrl) {
                $title = $node->filterXPath($converter->toXPath('strong'))->text();
                $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');

                return new SetLink($title, $url);
            })
        );

        return $setLinks;
    }

    /**
     * @param $attribute
     * @param $cardInfo
     * @param $cardUrl
     * @param null $logger
     * @param string $lang
     * @return \App\Entities\CardCarrier
     */
    public static function fetchCard($attribute, $cardInfo, $cardUrl, $logger = null, $lang = 'en')
    {
        if ($logger) {
            $logger->info('  crawling card: ' . $cardUrl);
        }

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
            return static::fetchSpell($cardUrl);
        } else if ($attribute == $attributes['trap']) {
            return static::fetchTrap($cardUrl);
        } else {
            if (Str::contains($cardInfo, 'Pendulum')) {
                return static::fetchPendulumMonster($cardUrl);
            }

            if (Str::contains($cardInfo, 'Link')) {
                return static::fetchLinkMonster($cardUrl);
            }

            if (Str::contains($cardInfo, 'Xyz')) {
                return static::fetchXyzMonster($cardUrl);
            }

            if (Str::contains($cardInfo, 'Synchro')) {
                return static::fetchSynchroMonster($cardUrl);
            }

            if (Str::contains($cardInfo, 'Ritual')) {
                return static::fetchRitualMonster($cardUrl);
            }

            return static::fetchMonster($cardUrl);
        }
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\LocaleSpecificCard
     */
    public static function fetchEnglishCardFields($cardUrl)
    {
        return static::fetchLocaleSpecificCardFields($cardUrl, 'en');
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\LocaleSpecificCard
     */
    public static function fetchGermanCardFields($cardUrl)
    {
        return static::fetchLocaleSpecificCardFields($cardUrl, 'de');
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @param \Symfony\Component\CssSelector\CssSelectorConverter $converter
     * @return bool
     */
    public static function fetchIsForbidden(Crawler $crawler, CssSelectorConverter $converter)
    {
        $forbiddenNode = $crawler->filterXPath($converter->toXPath('div.forbidden_limited > span'));

        if ($forbiddenNode->count() > 0 && $forbiddenNode->text() == 'Forbidden') {
            return true;
        }

        return false;
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @param \Symfony\Component\CssSelector\CssSelectorConverter $converter
     * @return bool
     */
    public static function fetchIsLimited(Crawler $crawler, CssSelectorConverter $converter)
    {
        $forbiddenNode = $crawler->filterXPath($converter->toXPath('div.forbidden_limited > span'));

        if ($forbiddenNode->count() > 0 && $forbiddenNode->text() == 'Limited') {
            return true;
        }

        return false;
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchLinkMonster($cardUrl)
    {
        $cardCarrier = static::fetchMonster($cardUrl);

        $linkMonsterCard = new LinkMonsterCard($cardCarrier->getCard()->toArray());
        $linkMonsterCard->link = $cardCarrier->getCard()->level;

        return new CardCarrier($linkMonsterCard, $cardCarrier->getCardSets());
    }

    /**
     * @param string $cardUrl
     * @param string $lang
     * @return \App\Entities\LocaleSpecificCard
     */
    public static function fetchLocaleSpecificCardFields($cardUrl, $lang)
    {
        $html = CommonHelper::getExternalContent($cardUrl, $lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box_text'))
            ->each(static::childrenRemover());

        $title = $crawler->filterXPath($converter->toXPath('nav#pan_nav > ul > li:nth-child(3)'))->text();

        $cardText = $boxDetails[0];
        $additionalText = null;

        if (count($boxDetails) > 1) {
            $additionalText = $boxDetails[0];
            $cardText = $boxDetails[1];
        }

        $cardSets = static::fetchLocalizedCardSets($crawler, $lang);

        return new LocaleSpecificCard($title, $cardText, $additionalText, $cardSets);
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $node
     * @param string $lang
     * @return \Illuminate\Support\Collection<\App\Entities\CardSet>
     */
    public static function fetchLocalizedCardSets(Crawler $node, $lang)
    {
        $converter = new CssSelectorConverter();

        return collect($node->filterXPath($converter->toXPath('div#pack_list tr.row'))->each(function (Crawler $subNode) use ($converter, $lang) {
            $values = $subNode->filterXPath($converter->toXPath('td'))->each(function (Crawler $subSubNode) {
                return trim($subSubNode->text());
            });

            $identifiers = explode('-', $values[1]);

            $setIdentifier = $identifiers[0];
            $cardIdentifier = $identifiers[1];
            $title = $values[2];

            $rarityNode = $subNode->filterXPath($converter->toXPath('td > img.icon_info'))->first();

            $rarity = $rarityNode->count() > 0 ? $rarityNode->attr('alt') : 'Common';

            return new CardSet($setIdentifier, $cardIdentifier, $title, $rarity, $lang);
        }));
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchMonster($cardUrl)
    {
        $germanCardFields = static::fetchGermanCardFields($cardUrl);
        $englishCardFields = static::fetchEnglishCardFields($cardUrl);
        $html = CommonHelper::getExternalContent($cardUrl);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $tabularDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box > span.item_box_value'))
            ->each(function (Crawler $node) {
                return trim($node->text());
            });
        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box.t_center'))
            ->each(static::childrenRemover());

        $monsterCard = new MonsterCard();
        $monsterCard->title_german = $germanCardFields->getTitle();
        $monsterCard->title_english = $englishCardFields->getTitle();
        $monsterCard->attribute = $tabularDetails[0];
        $monsterCard->level = intval($tabularDetails[1]);
        $monsterCard->monster_type = $boxDetails[0];
        $monsterCard->card_type = CommonHelper::removeWhiteSpaces($boxDetails[1]);
        $monsterCard->atk = $tabularDetails[2];
        $monsterCard->def = $tabularDetails[3];
        $monsterCard->card_text_german = $germanCardFields->getCardText();
        $monsterCard->card_text_english = $englishCardFields->getCardText();
        $monsterCard->url = $cardUrl;
        $monsterCard->is_forbidden = static::fetchIsForbidden($crawler, $converter);
        $monsterCard->is_limited = static::fetchIsLimited($crawler, $converter);

        $cardSets = $germanCardFields->getCardSets()->merge($englishCardFields->getCardSets());

        return new CardCarrier($monsterCard, $cardSets);
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchPendulumMonster($cardUrl)
    {
        $germanCardFields = static::fetchGermanCardFields($cardUrl);
        $englishCardFields = static::fetchEnglishCardFields($cardUrl);
        $html = CommonHelper::getExternalContent($cardUrl);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $tabularDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box > span.item_box_value'))
            ->each(function (Crawler $node) {
                return trim($node->text());
            });
        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box.t_center'))
            ->each(static::childrenRemover());

        $pendulumMonsterCard = new PendulumMonsterCard();
        $pendulumMonsterCard->title_german = $germanCardFields->getTitle();
        $pendulumMonsterCard->title_english = $englishCardFields->getTitle();
        $pendulumMonsterCard->attribute = $tabularDetails[0];
        $pendulumMonsterCard->level = intval($tabularDetails[1]);
        $pendulumMonsterCard->pendulum_scale = intval($boxDetails[0]);
        $pendulumMonsterCard->pendulum_effect_german = $germanCardFields->getAdditionalText();
        $pendulumMonsterCard->pendulum_effect_english = $englishCardFields->getAdditionalText();
        $pendulumMonsterCard->monster_type = $boxDetails[1];
        $pendulumMonsterCard->card_type = CommonHelper::removeWhiteSpaces($boxDetails[2]);
        $pendulumMonsterCard->atk = $tabularDetails[2];
        $pendulumMonsterCard->def = $tabularDetails[3];
        $pendulumMonsterCard->card_text_german = $germanCardFields->getCardText();
        $pendulumMonsterCard->card_text_english = $englishCardFields->getCardText();
        $pendulumMonsterCard->url = $cardUrl;
        $pendulumMonsterCard->is_forbidden = static::fetchIsForbidden($crawler, $converter);
        $pendulumMonsterCard->is_limited = static::fetchIsLimited($crawler, $converter);

        $cardSets = $germanCardFields->getCardSets()->merge($englishCardFields->getCardSets());

        return new CardCarrier($pendulumMonsterCard, $cardSets);
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchRitualMonster($cardUrl)
    {
        $cardCarrier = static::fetchMonster($cardUrl);

        $ritualMonsterCard = new RitualMonsterCard($cardCarrier->getCard()->toArray());

        return new CardCarrier($ritualMonsterCard, $cardCarrier->getCardSets());
    }

    /**
     * @param string $baseUrl
     * @param string $setUrl
     * @param string $lang
     * @return \Illuminate\Support\Collection
     */
    public static function fetchSetCards($baseUrl, $setUrl, $lang = null)
    {
        $html = CommonHelper::getExternalContent($setUrl, $lang);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $setCards = collect($crawler
            ->filterXPath($converter->toXPath('ul.box_list > li'))
            ->each(function (Crawler $node) use ($baseUrl, $converter) {
                $cardInfoNode = $node->filterXPath($converter->toXPath('dd.box_card_spec > span.card_info_species_and_other_item'));

                $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');
                $attribute = trim($node->filterXPath($converter->toXPath('dd.box_card_spec > span.box_card_attribute'))->text());
                $cardInfo = $cardInfoNode->count() == 1 ? CommonHelper::removeWhiteSpaces($cardInfoNode->text()) : null;

                return new SetCard($url, $attribute, $cardInfo);
            })
        );

        return $setCards;
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchSpell($cardUrl)
    {
        $card = static::fetchSpellOrTrap($cardUrl);

        $spellCard = new SpellCard();
        $spellCard->title_german = $card->getTitleGerman();
        $spellCard->title_english = $card->getTitleEnglish();
        $spellCard->icon = $card->getIcon();
        $spellCard->card_text_german = $card->getCardTextGerman();
        $spellCard->card_text_english = $card->getCardTextEnglish();
        $spellCard->url = $cardUrl;
        $spellCard->is_forbidden = $card->isForbidden();
        $spellCard->is_limited = $card->isLimited();

        return new CardCarrier($spellCard, $card->getCardSets());
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\Card
     */
    public static function fetchSpellOrTrap($cardUrl)
    {
        $germanCardFields = static::fetchGermanCardFields($cardUrl);
        $englishCardFields = static::fetchEnglishCardFields($cardUrl);
        $html = CommonHelper::getExternalContent($cardUrl);

        $crawler = new Crawler($html);
        $converter = new CssSelectorConverter();

        $tabularDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box'))->each(static::childrenRemover());

        $cardSets = $germanCardFields->getCardSets()->merge($englishCardFields->getCardSets());

        return new Card(
            $germanCardFields->getTitle(),
            $englishCardFields->getTitle(),
            $tabularDetails[0],
            $germanCardFields->getCardText(),
            $englishCardFields->getCardText(),
            static::fetchIsForbidden($crawler, $converter),
            static::fetchIsLimited($crawler, $converter),
            $cardSets
        );
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchSynchroMonster($cardUrl)
    {
        $cardCarrier = static::fetchMonster($cardUrl);

        $synchroMonsterCard = new SynchroMonsterCard($cardCarrier->getCard()->toArray());

        return new CardCarrier($synchroMonsterCard, $cardCarrier->getCardSets());
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchTrap($cardUrl)
    {
        $card = static::fetchSpellOrTrap($cardUrl);

        $trapCard = new TrapCard();
        $trapCard->title_german = $card->getTitleGerman();
        $trapCard->title_english = $card->getTitleEnglish();
        $trapCard->icon = $card->getIcon();
        $trapCard->card_text_german = $card->getCardTextGerman();
        $trapCard->card_text_english = $card->getCardTextEnglish();
        $trapCard->url = $cardUrl;
        $trapCard->is_forbidden = $card->isForbidden();
        $trapCard->is_limited = $card->isLimited();

        return new CardCarrier($trapCard, $card->getCardSets());
    }

    /**
     * @param string $cardUrl
     * @return \App\Entities\CardCarrier
     */
    public static function fetchXyzMonster($cardUrl)
    {
        $cardCarrier = static::fetchMonster($cardUrl);

        $xyzMonsterCard = new XyzMonsterCard($cardCarrier->getCard()->toArray());
        $xyzMonsterCard->rank = $cardCarrier->getCard()->level;

        return new CardCarrier($xyzMonsterCard, $cardCarrier->getCardSets());
    }
}