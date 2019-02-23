<?php

namespace App\Entities;

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
     * @param string $titleGerman
     * @param string $titleEnglish
     * @param string $icon
     * @param string $cardTextGerman
     * @param string $cardTextEnglish
     * @param bool $isForbidden
     */
    public function __construct($titleGerman, $titleEnglish, $icon, $cardTextGerman, $cardTextEnglish, $isForbidden)
    {
        $this->titleGerman = $titleGerman;
        $this->titleEnglish = $titleEnglish;
        $this->icon = $icon;
        $this->cardTextGerman = $cardTextGerman;
        $this->cardTextEnglish = $cardTextEnglish;
        $this->isForbidden = $isForbidden;
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
}
