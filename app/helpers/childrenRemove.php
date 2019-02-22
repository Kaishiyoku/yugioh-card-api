<?php

if (!function_exists('childrenRemover')) {
    /**
     * @return Closure
     */
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
