<?php
namespace youtube\classes;

use youtube\interfaces\Fetch;

class HtmlFetch implements Fetch
{
    /**
     * @var resource
     */
    private $context;

    public function __construct()
    {
        $this->context = stream_context_create(array('http' => array('timeout' => YT_STATUS_TIMEOUT)));
    }

    /**
     * @param string $url
     * @return string
     */
    public function getContent($url)
    {
        return mb_convert_encoding(@file_get_contents(trim($url), FALSE, $this->context), 'HTML-ENTITIES', 'UTF-8');
    }
}