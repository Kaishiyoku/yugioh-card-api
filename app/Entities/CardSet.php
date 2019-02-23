<?php

namespace App\Entities;

class CardSet
{
    /**
     * @var string
     */
    private $setIdentifier;

    /**
     * @var string
     */
    private $cardIdentifier;

    /**
     * @var string
     */
    private $title;

    public function __construct($setIdentifier, $cardIdentifier, $title)
    {
        $this->setIdentifier = $setIdentifier;
        $this->cardIdentifier = $cardIdentifier;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSetIdentifier()
    {
        return $this->setIdentifier;
    }

    /**
     * @return string
     */
    public function getCardIdentifier()
    {
        return $this->cardIdentifier;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'setIdentifier' => $this->getSetIdentifier(),
            'cardIdentifier' => $this->getCardIdentifier(),
            'title' => $this->getTitle(),
        ];
    }
}
