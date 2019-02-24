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
    private $rarity;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $lang;

    /**
     * @param string $setIdentifier
     * @param string $cardIdentifier
     * @param string $title
     * @param string $rarity
     * @param string $lang
     */
    public function __construct($setIdentifier, $cardIdentifier, $title, $rarity, $lang)
    {
        $this->setIdentifier = $setIdentifier;
        $this->cardIdentifier = $cardIdentifier;
        $this->title = $title;
        $this->rarity = $rarity;
        $this->lang = $lang;
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
     * @return string
     */
    public function getRarity()
    {
        return $this->rarity;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
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
            'rarity' => $this->getRarity(),
            'lang' => $this->getLang(),
        ];
    }
}
