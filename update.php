<?php
ob_start();
var_dump($_POST);
$result = ob_get_clean();

fwrite(fopen("output.txt"), $result);
