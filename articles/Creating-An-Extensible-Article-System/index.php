<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/PagePrimitives.php');
$timer = new PageTimer();
$timer->start();
PagePrimitives::std_page();
PagePrimitives::std_article(basename(__DIR__));
$timer->stop();
WebConsole::Log($timer);
?>
    