<?php

if (!function_exists('filterInt')) {
    /**
     * @param string|null $str
     * @return int
     */
    function filterInt($str)
    {
        preg_match("/-?[0-9]+/", $str, $matches);

        if (count($matches) == 0) {
            return null;
        }

        return $matches[0];
    }
}

if (!function_exists('getExternalContent')) {
    /**
     * @param string $url
     * @param string $lang
     * @return string
     */
    function getExternalContent($url, $lang = 'en')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: ' . $lang]);
        curl_setopt($ch, CURLOPT_URL, $url);

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}

if (!function_exists('arrEach')) {
    /**
     * @param callable $callback
     * @param array $arr
     */
    function arrEach(callable $callback, array $arr): void
    {
        foreach ($arr as $key => $item) {
            $callback($item, $key);
        }
    }
}

if (!function_exists('arrMap')) {
    /**
     * @param callable $callback
     * @param array $arr
     * @return array
     */
    function arrMap(callable $callback, array $arr): array
    {
        $newArray = [];

        foreach ($arr as $key => $item) {
            $newArray[$key] = $callback($item, $key);
        }

        return $newArray;
    }
}

if (!function_exists('arrReduce')) {
    /**
     * @param callable $callback
     * @param array $arr
     * @param null|mixed $initial
     * @return mixed
     */
    function arrReduce(callable $callback, array $arr, $initial = null)
    {
        return array_reduce($arr, $callback, $initial);
    }
}

if (!function_exists('fetchAllSetLinks')) {
    /**
     * @param string $baseUrl
     * @param string $lang
     * @return \Illuminate\Support\Collection
     */
    function fetchAllSetLinks($baseUrl, $lang = null)
    {
        $html = getExternalContent($baseUrl . '/yugiohdb/card_list.action', $lang);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $setLinks = collect($crawler
            ->filterXPath($converter->toXPath('div#card_list_1 div.pack'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) use ($converter, $baseUrl) {
                $title = $node->filterXPath($converter->toXPath('strong'))->text();
                $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');

                return new \App\Entities\SetLink($title, $url);
            })
        );

        return $setLinks;
    }
}

if (!function_exists('fetchSetCards')) {
    /**
     * @param string $baseUrl
     * @param string $setUrl
     * @param string $lang
     * @return \Illuminate\Support\Collection
     */
    function fetchSetCards($baseUrl, $setUrl, $lang = null)
    {
        $html = getExternalContent($setUrl, $lang);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $setCards = collect($crawler
            ->filterXPath($converter->toXPath('ul.box_list > li'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) use ($baseUrl, $converter) {
                $cardInfoNode = $node->filterXPath($converter->toXPath('dd.box_card_spec > span.card_info_species_and_other_item'));

                $url = $baseUrl . $node->filterXPath($converter->toXPath('input.link_value[type=hidden]'))->attr('value');
                $attribute = trim($node->filterXPath($converter->toXPath('dd.box_card_spec > span.box_card_attribute'))->text());
                $cardInfo = $cardInfoNode->count() == 1 ? removeWhiteSpaces($cardInfoNode->text()) : null;

                return new \App\Entities\SetCard($url, $attribute, $cardInfo);
            })
        );

        return $setCards;
    }
}

if (!function_exists('fetchCard')) {
    /**
     * @param $attribute
     * @param $cardUrl
     * @param null $logger
     * @param $lang
     * @return \Illuminate\Database\Eloquent\Model
     */
    function fetchCard($attribute, $cardInfo, $cardUrl, $logger = null, $lang = 'en')
    {
        if ($logger) {
            $logger->info('  crawling card: ' .$cardUrl);
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
            return fetchSpell($cardUrl);
        } else if ($attribute == $attributes['trap']) {
            return fetchTrap($cardUrl);
        } else {
            if (\Illuminate\Support\Str::contains($cardInfo, 'Pendulum')) {
                return fetchPendulumMonster($cardUrl);
            }

            if (\Illuminate\Support\Str::contains($cardInfo, 'Link')) {
                return fetchLinkMonster($cardUrl);
            }

            return fetchMonster($cardUrl);
        }
    }
}

if (!function_exists('fetchLinkMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\LinkMonsterCard
     */
    function fetchLinkMonster($cardUrl)
    {
        $monsterCard = fetchMonster($cardUrl);

        $linkMonsterCard = new \App\Models\LinkMonsterCard($monsterCard->toArray());
        $linkMonsterCard->link = $monsterCard->level;

        return $linkMonsterCard;
    }
}

if (!function_exists('fetchPendulumMonster')) {
    function fetchPendulumMonster($cardUrl)
    {
        $germanCardFields = fetchGermanCardFields($cardUrl);
        $englishCardFields = fetchEnglishCardFields($cardUrl);
        $html = getExternalContent($cardUrl);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $tabularDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box > span.item_box_value'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
                return trim($node->text());
            });
        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box.t_center'))
            ->each(childrenRemover());

        $pendulumMonsterCard = new \App\Models\PendulumMonsterCard();
        $pendulumMonsterCard->title_german = $germanCardFields->getTitle();
        $pendulumMonsterCard->title_english = $englishCardFields->getTitle();
        $pendulumMonsterCard->attribute = $tabularDetails[0];
        $pendulumMonsterCard->level = intval($tabularDetails[1]);
        $pendulumMonsterCard->pendulum_scale = intval($boxDetails[0]);
        $pendulumMonsterCard->pendulum_effect_german = $germanCardFields->getAdditionalText();
        $pendulumMonsterCard->pendulum_effect_english = $englishCardFields->getAdditionalText();
        $pendulumMonsterCard->monster_type = $boxDetails[1];
        $pendulumMonsterCard->card_type = removeWhiteSpaces($boxDetails[2]);
        $pendulumMonsterCard->atk = $tabularDetails[2];
        $pendulumMonsterCard->def = $tabularDetails[3];
        $pendulumMonsterCard->card_text_german = $germanCardFields->getCardText();
        $pendulumMonsterCard->card_text_english = $englishCardFields->getCardText();
        $pendulumMonsterCard->url = $cardUrl;

        return $pendulumMonsterCard;
    }
}

if (!function_exists('fetchMonster')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\MonsterCard
     */
    function fetchMonster($cardUrl)
    {
        $germanCardFields = fetchGermanCardFields($cardUrl);
        $englishCardFields = fetchEnglishCardFields($cardUrl);
        $html = getExternalContent($cardUrl);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $tabularDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box > span.item_box_value'))
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
                return trim($node->text());
            });
        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box.t_center'))
            ->each(childrenRemover());

        $monsterCard = new \App\Models\MonsterCard();
        $monsterCard->title_german = $germanCardFields->getTitle();
        $monsterCard->title_english = $englishCardFields->getTitle();
        $monsterCard->attribute = $tabularDetails[0];
        $monsterCard->level = intval($tabularDetails[1]);
        $monsterCard->monster_type = $boxDetails[0];
        $monsterCard->card_type = removeWhiteSpaces($boxDetails[1]);
        $monsterCard->atk = $tabularDetails[2];
        $monsterCard->def = $tabularDetails[3];
        $monsterCard->card_text_german = $germanCardFields->getCardText();
        $monsterCard->card_text_english = $englishCardFields->getCardText();
        $monsterCard->url = $cardUrl;

        return $monsterCard;
    }
}

if (!function_exists('fetchSpellOrTrap')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\Card
     */
    function fetchSpellOrTrap($cardUrl)
    {
        $germanCardFields = fetchGermanCardFields($cardUrl);
        $englishCardFields = fetchEnglishCardFields($cardUrl);
        $html = getExternalContent($cardUrl);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $tabularDetails = $crawler->filterXPath($converter->toXPath('table#details div.item_box'))->each(childrenRemover());

        return new \App\Entities\Card(
            $germanCardFields->getTitle(),
            $englishCardFields->getTitle(),
            $tabularDetails[0],
            $germanCardFields->getCardText(),
            $englishCardFields->getCardText()
        );
    }
}

if (!function_exists('fetchSpell')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\SpellCard
     */
    function fetchSpell($cardUrl)
    {
        $card = fetchSpellOrTrap($cardUrl);

        $spellCard = new \App\Models\SpellCard();
        $spellCard->title_german = $card->getTitleGerman();
        $spellCard->title_english = $card->getTitleEnglish();
        $spellCard->icon = $card->getIcon();
        $spellCard->card_text_german = $card->getCardTextGerman();
        $spellCard->card_text_english = $card->getCardTextEnglish();
        $spellCard->url = $cardUrl;

        return $spellCard;
    }
}

if (!function_exists('fetchTrap')) {
    /**
     * @param string $cardUrl
     * @return \App\Models\TrapCard
     */
    function fetchTrap($cardUrl)
    {
        $card = fetchSpellOrTrap($cardUrl);

        $trapCard = new \App\Models\TrapCard();
        $trapCard->title_german = $card->getTitleGerman();
        $trapCard->title_english = $card->getTitleEnglish();
        $trapCard->icon = $card->getIcon();
        $trapCard->card_text_german = $card->getCardTextGerman();
        $trapCard->card_text_english = $card->getCardTextEnglish();
        $trapCard->url = $cardUrl;

        return $trapCard;
    }
}

if (!function_exists('fetchGermanCardFields')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\LocaleSpecificCard
     */
    function fetchGermanCardFields($cardUrl)
    {
        return fetchLocaleSpecificCardFields($cardUrl, 'de');
    }
}

if (!function_exists('fetchEnglishCardFields')) {
    /**
     * @param string $cardUrl
     * @return \App\Entities\LocaleSpecificCard
     */
    function fetchEnglishCardFields($cardUrl)
    {
        return fetchLocaleSpecificCardFields($cardUrl, 'en');
    }
}

if (!function_exists('fetchLocaleSpecificCardFields')) {
    /**
     * @param string $cardUrl
     * @param string $lang
     * @return \App\Entities\LocaleSpecificCard
     */
    function fetchLocaleSpecificCardFields($cardUrl, $lang)
    {
        $html = getExternalContent($cardUrl, $lang);

        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $converter = new \Symfony\Component\CssSelector\CssSelectorConverter();

        $boxDetails = $crawler
            ->filterXPath($converter->toXPath('table#details div.item_box_text'))
            ->each(childrenRemover());

        $title = $crawler->filterXPath($converter->toXPath('nav#pan_nav > ul > li:nth-child(3)'))->text();

        $cardText = $boxDetails[0];
        $additionalText = null;

        if (count($boxDetails) > 1) {
            $additionalText = $boxDetails[0];
            $cardText = $boxDetails[1];
        }

        return new \App\Entities\LocaleSpecificCard($title, $cardText, $additionalText);
    }
}

if (!function_exists('childrenRemover')) {
    function childrenRemover()
    {
        return function (\Symfony\Component\DomCrawler\Crawler $node) {
            $domElement = $node->getNode(0);

            foreach ($node->children() as $child) {
                $domElement->removeChild($child);
            }

            return trim($node->text());
        };
    }
}

if (!function_exists('removeWhiteSpaces')) {
    function removeWhiteSpaces($str)
    {
        return str_replace(["\t", "\r", "\n"], '', $str);
    }
}