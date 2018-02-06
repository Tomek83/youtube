<?php
namespace youtube\classes;

use youtube\interfaces\Dom;

class HtmlDom implements Dom
{
    /**
     * @var \DOMDocument
     */
    private $domDoc;

    public function __construct()
    {
        $this->domDoc = new \DOMDocument();
    }

    /**
     * @param string $html
     */
    public function loadHtml($html)
    {
        $this->domDoc->loadHTML($html);
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        $domList = (new \DOMXPath($this->domDoc))->query('//*/meta[starts-with(@property, \'og:\')]');
        return $this->parseList($domList);
    }

    /**
     * @param \DOMNodeList $domList
     * @return array
     */
    private function parseList(\DOMNodeList $domList)
    {
        $meta = [];

        foreach ($domList as $item) {
            $meta[trim($item->getAttribute('property'))] = trim($item->getAttribute('content'));
        }

        return $meta;
    }
}