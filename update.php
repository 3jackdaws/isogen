<?php
ob_start();
var_dump($_POST);
$result = ob_get_clean();
$handle = fopen("output.txt", "w");
fwrite($handle, $result);
fclose($handle);


