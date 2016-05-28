<?php
ob_start();
var_dump($_POST);
$result = ob_get_clean();
$var;
fwrite(fopen("output.txt", "w"), $result);
