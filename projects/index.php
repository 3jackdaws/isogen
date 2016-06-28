<?php
$start = microtime(true);
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/Page.php');
$page = new CustomPage();
$page->writeHead();
$page->writeNavbar();

$projects = glob(__DIR__ . "/*", GLOB_ONLYDIR);


?>
<div class="container">
    <ul>
        <?php
        foreach ($projects as $dir)
        {
            ?>
            <li><a href="/projects/<?=basename($dir)?>"><?=basename($dir)?></a></li>
            <?php
        }
        ?>

    </ul>
</div>


<?php
$page->writeFooter();
$end = microtime(true);


WebConsole::Log("Page created in " . round(($end - $start)*1000, 0) . " milliseconds");
?>