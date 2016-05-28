<?php

$json = json_decode($_POST["payload"]);
ob_start();
var_dump($_POST);
$post = ob_get_clean();
$handle = fopen("json.txt", "w");
fwrite($handle, $json);
fclose($handle);
$handle = fopen("POST.txt", "w");
fwrite($handle, $post);
fclose($handle);
#kill me, dsakjgl;fkns;lgn


