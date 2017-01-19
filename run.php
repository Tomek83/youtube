#!/usr/bin/php
<?php

require_once('class/yt_stat.inc.php');
require_once('config.inc.php');

try {

	$url=(empty($argv[1])) ? NULL : trim($argv[1]);

	if (is_null($url)) throw new Exception('No video URL provided');

	$obj=new yt_stat($url);

	print_r($obj->__info);

} catch (Exception $e) {

    print "Exception: ".$e->getMessage()."!\n";

}

?>
