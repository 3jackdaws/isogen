<?php
$start = microtime(true);
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/Page.php');

$page = new MainPage();
$page->createPage();
$end = microtime(true);

WebConsole::Log("Total creation took: " . ($end - $start));
?>

