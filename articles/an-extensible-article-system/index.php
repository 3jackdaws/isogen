<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/Page.php');

$page = new \Page\ArticlePage(basename(__DIR__));
$page->createPage();
?>


    





