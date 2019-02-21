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
     * @param string $url
     * @param string $attribute
     */
    public function __construct($url, $attribute)
    {
        $this->url = $url;
        $this->attribute = $attribute;
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
}
