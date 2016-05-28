<?php

$json = json_decode($_POST["payload"]);

$handle = fopen("json.txt", "w");
fwrite($handle, $json);
fclose($handle);
$handle = fopen("POST.txt", "w");
fwrite($handle, $_POST);
fclose($handle);
#kill me, dsakjgl;fkns;lgn


