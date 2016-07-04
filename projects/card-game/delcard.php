<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 7/4/16
 * Time: 1:15 PM
 */


$basepath = realpath($_SERVER["DOCUMENT_ROOT"]);
require($basepath . "/assets/php/json_response.php");
$card = $_GET["card"];
$response = new json_response();
$response->add_content_to_field("Card Name", $card);
$response->add_content_to_field("Post", $_GET);

error_log("REQUESTED DELETE CARD: " . $_SERVER["REMOTE_HOST"]);

if(!unlink($basepath . "/projects/card-game/cards/" . $card . ".json")){
    $response->add_error("Failed to unlink " . $card . ".json");
}
if(!(unlink($basepath . "/projects/card-game/cards/" . $card . ".png") || unlink($basepath . "/projects/card-game/cards/" . $card . ".jpg"))){
    $response->add_error("Failed to unlink image");
}


echo $response;
