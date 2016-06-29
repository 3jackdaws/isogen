<?php
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/PagePrimitives.php');
PagePrimitives::std_page("Projects");
$projects = glob(__DIR__ . "/*", GLOB_ONLYDIR);

?>
<div class="container" style="margin-top: 100px; width">
    <div class="list-group">
        <?php
        foreach ($projects as $dir)
        {
            ?>
            <a class="list-group-item list-group-item-info " href="/projects/<?=basename($dir)?>"><?=basename($dir)?></a>
            <?php
        }
        ?>

    </div>
</div>


<?php

?>