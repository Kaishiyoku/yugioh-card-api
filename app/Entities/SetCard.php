<?php

namespace App\Entities;

class SetCard
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $cardInfo;

    /**
     * @param string $url
     * @param string $attribute
     * @param string $cardInfo
     */
    public function __construct($url, $attribute, $cardInfo = null)
    {
        $this->url = $url;
        $this->attribute = $attribute;
        $this->cardInfo = $cardInfo;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return string
     */
    public function getCardInfo()
    {
        return $this->cardInfo;
    }
}
