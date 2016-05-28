<?php

$json = json_decode($_POST["payload"]);
ob_start();
var_dump($_POST);
$post = ob_get_clean();
error_log($json["commits"]["message"]);
#kill me, dsakjgl;fkns;lgn 


