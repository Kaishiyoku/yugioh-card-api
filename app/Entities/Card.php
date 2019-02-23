<?php

namespace App\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class Card
{
    /**
     * @var string
     */
    private $titleGerman;

    /**
     * @var string
     */
    private $titleEnglish;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $cardTextGerman;

    /**
     * @var string
     */
    private $cardTextEnglish;

    /**
     * @var bool
     */
    private $isForbidden;

    /**
     * @var bool
     */
    private $isLimited;

    /**
     * @var Collection<CardSet>
     */
    private $cardSets;

    /**
     * @param string $titleGerman
     * @param string $titleEnglish
     * @param string $icon
     * @param string $cardTextGerman
     * @param string $cardTextEnglish
     * @param bool $isForbidden
     * @param bool $isLimited
     * @param Collection<CardSet>
     */
    public function __construct($titleGerman, $titleEnglish, $icon, $cardTextGerman, $cardTextEnglish, $isForbidden, $isLimited, $cardSets)
    {
        $this->titleGerman = $titleGerman;
        $this->titleEnglish = $titleEnglish;
        $this->icon = $icon;
        $this->cardTextGerman = $cardTextGerman;
        $this->cardTextEnglish = $cardTextEnglish;
        $this->isForbidden = $isForbidden;
        $this->isLimited = $isLimited;
        $this->cardSets = $cardSets;
    }

    /**
     * @return string
     */
    public function getTitleGerman(): string
    {
        return $this->titleGerman;
    }

    /**
     * @return string
     */
    public function getTitleEnglish(): string
    {
        return $this->titleEnglish;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getCardTextGerman(): string
    {
        return $this->cardTextGerman;
    }

    /**
     * @return string
     */
    public function getCardTextEnglish(): string
    {
        return $this->cardTextEnglish;
    }

    /**
     * @return bool
     */
    public function isForbidden(): bool
    {
        return $this->isForbidden;
    }

    /**
     * @return bool
     */
    public function isLimited(): bool
    {
        return $this->isLimited;
    }

    /**
     * @return Collection<CardSet>
     */
    public function getCardSets()
    {
        return $this->cardSets;
    }
}
