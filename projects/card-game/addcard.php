<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/25/2016
 * Time: 8:11 PM
 */
$basepath = realpath($_SERVER{"DOCUMENT_ROOT"});
require($basepath . "/assets/php/json_response.php");

$card = fopen("cards/" . $_POST["name"] . ".json", "x");
$response = new json_response();
if($card){
    $card_data= $_POST;
    $web_dir = "/projects/card-game/cards/" . $card_data["name"];
    switch ($_FILES["pic"]["type"]){
        case "image/jpeg":
            $web_dir .=".jpg";
            break;
        case "image/png":
            $web_dir .= ".png";
            break;
        default:

    }
    $upload_dir = realpath($_SERVER["DOCUMENT_ROOT"]) . $web_dir;
    $temp = $_FILES["pic"]["tmp_name"];
    if(!move_uploaded_file($temp, $upload_dir)){
        $response->add_error("Could not move uploaded file");
    }

    $card_data["pic"] = $web_dir;
    fwrite($card, json_encode($card_data));

    $response->add_message("Card successfully created");
    echo $response;
}else{  ///card already exists
    $response->add_error("Card already exists");
    echo $response;
}