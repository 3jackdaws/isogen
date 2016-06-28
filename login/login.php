<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/19/2016
 * Time: 8:42 PM
 */

if(isset($_POST["user"])){
    require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/AuthModule.php");
    $v = $_POST;
    if(isset($v["password"])){
        $authmod = new AuthModule();
        echo $authmod->login($v["user"], $v["password"]);
    }
    else{
        $r = [];
        $r["error"] = 1;
        $r["message"] = "Missing required parameters";
        echo json_encode($r);
    }
    exit();
}