<?php

$json = json_decode($_POST["payload"]);
ob_start();
var_dump($json);
$result = ob_get_clean();
$handle = fopen("output.txt", "w");
fwrite($handle, $result);
fclose($handle);
#kill me, dsakjgl;fkns;lgn


