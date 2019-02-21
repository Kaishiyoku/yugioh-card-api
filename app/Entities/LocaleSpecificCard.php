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
     * @param string $title
     * @param string $cardText
     */
    public function __construct($title, $cardText)
    {
        $this->title = $title;
        $this->cardText = $cardText;
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
}
