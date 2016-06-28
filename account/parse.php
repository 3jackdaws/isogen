<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/27/2016
 * Time: 5:49 PM
 */
$response = [];
$upload_dir = realpath($_SERVER["DOCUMENT_ROOT"]) . "/account/temp/";
$pre_existing = glob($upload_dir . "*");
$response["pre"] = $pre_existing;
foreach ($pre_existing as $todelete){
    if(basename($todelete) !== "index.php" and basename($todelete) !== "cp.php")
        unlink($todelete);
}

$files = $_FILES["files"];
$num_files = count($files["name"]);
for ($i = 0; $i<$num_files; $i++){
    if($files["type"][$i] == "text/html"){
        move_uploaded_file($files["tmp_name"][$i], $upload_dir . "markup.html");
    }else{
        move_uploaded_file($files["tmp_name"][$i], $upload_dir . $files["name"][$i]);
    }

}

include(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/ArticleParser.php");

$article = ArticleParser("/account/temp", true);


$response["error"] = 0;
$response["publishdir"] = $article["publish-to"];

if(strlen($article["author"]) == 0){
    $response["error"] = 1;
    $response["errorlines"][] = "Author tag not set";
}
if(strlen($article["date"]) == 0){
    $response["error"] = 1;
    $response["errorlines"][] = "Date tag not set";
}
if(!strpos($article["header_image"], ".")){
    $response["error"] = 1;
    $response["errorlines"][] = "No header image specified";
}
if(strlen($article["h1"]) == 0){
    $response["error"] = 1;
    $response["errorlines"][] = "No title set ";
}
if(strlen($article["h2"]) == 0){
    $response["error"] = 1;
    $response["errorlines"][] = "No subheading set ";
}

//echo json_encode($uploads);
echo json_encode($response);
