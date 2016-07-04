<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/PagePrimitives.php');
$timer = new PageTimer();
$timer->start();
echo "<html><head>";
PagePrimitives::std_head();
echo "</head><body>";
PagePrimitives::std_article("/account/temp", true);
$timer->stop();
WebConsole::Log($timer);
?>