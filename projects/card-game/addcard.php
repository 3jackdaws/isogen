<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/25/2016
 * Time: 8:11 PM
 */

$card = fopen("cards/" . $_POST["name"] . ".json", "w+");
$response = [];
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
        $response;
    }

    $card_data["pic"] = $web_dir;
    fwrite($card, json_encode($card_data));

    $response["error"] = 0;
    $response["message"] = "Cards successfully created";
    echo json_encode($response);
}else{  ///card already exists
    $response["error"] = 1;
    $response["message"] = "Card already exists";
    echo json_encode($response);
}