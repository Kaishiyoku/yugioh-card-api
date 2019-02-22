<?php

namespace App\Entities;

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
     * @param string $title
     * @param string $cardText
     * @param string $additionalText
     */
    public function __construct($title, $cardText, $additionalText)
    {
        $this->title = $title;
        $this->cardText = $cardText;
        $this->additionalText = $additionalText;
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
}
