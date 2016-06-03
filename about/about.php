<?php

include "/var/www/sites/isogen/assets/php/iso-includes/IsogenDatabase.php";
$database = new IsogenDatabase();
if($database->checkExistsArticle("preloading-")) echo "TRUE";
else echo "FALSE";
//var_dump($database);
