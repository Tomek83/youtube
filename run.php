#!/usr/bin/php
<?php

require_once 'vendor/autoload.php';

use youtube\classes\Youtube;
use youtube\classes\HtmlDom;
use youtube\classes\HtmlFetch;

try {

    $url = (empty($argv[1])) ? null : trim($argv[1]);

    if (is_null($url)) throw new Exception('video URL not provided');

    $youtube = new Youtube(new HtmlFetch(), new HtmlDom());

    $youtube->getVideo($url);

    print_r($youtube->videoData());

} catch (Exception $err) {

    print "Exception: " . $err->getMessage() . "!\n";

}