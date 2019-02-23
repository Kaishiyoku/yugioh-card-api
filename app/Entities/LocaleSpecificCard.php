<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class LocaleSpecificCard
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $cardText;

    /**
     * @var string
     */
    private $additionalText;

    /**
     * @var Collection<CardSet>
     */
    private $cardSets;

    /**
     * @param string $title
     * @param string $cardText
     * @param string $additionalText
     * @param Collection<CardSet> $cardSets
     */
    public function __construct($title, $cardText, $additionalText, $cardSets)
    {
        if (empty($cardSets)) {
            $cardSets = collect();
        }

        $this->title = $title;
        $this->cardText = $cardText;
        $this->additionalText = $additionalText;
        $this->cardSets = $cardSets;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCardText()
    {
        return $this->cardText;
    }

    /**
     * @return string
     */
    public function getAdditionalText(): string
    {
        return $this->additionalText;
    }

    /**
     * @return Collection<CardSet>
     */
    public function getCardSets()
    {
        return $this->cardSets;
    }
}
