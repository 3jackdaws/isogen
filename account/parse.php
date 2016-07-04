<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/27/2016
 * Time: 5:49 PM
 */
$response = [];
$response["error"] = 0;
$upload_dir = realpath($_SERVER["DOCUMENT_ROOT"]) . "/account/temp/";
$pre_existing = glob($upload_dir . "*");
foreach ($pre_existing as $todelete){
    if(basename($todelete) !== "index.php" and basename($todelete) !== "cp.php")
        unlink($todelete);
}

$files = $_FILES["files"];
$num_files = count($files["name"]);
$article_short_name = "":
for ($i = 0; $i<$num_files; $i++){
    if($files["type"][$i] == "text/html"){
        $article_short_name = basename($files["tmp_name"][$i]);
        move_uploaded_file($files["tmp_name"][$i], $upload_dir . "markup.html");
    }else{
        move_uploaded_file($files["tmp_name"][$i], $upload_dir . $files["name"][$i]);
    }

}

include(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/ArticleParser.php");

$article = ArticleParser("/account/temp", true);

$provided_files = [];
$files_in_dir = glob($upload_dir . "*");
foreach ($files_in_dir as $file){
    $provided_files[] = basename($file);
}

$required_files = [];
$required_files[] = "markup.html";
$required_files[] = basename($article["header_image"]);
foreach ($article["required_images"] as $img){
    $required_files[] = $img;
}

$missing_files = array_diff($required_files, $provided_files);
foreach ($missing_files as $missing_file) {
    $response["error"] = 1;
    $response["errorlines"][] = "Missing file: " . $missing_file;
}


$response["message"] = $article["publish-to"];

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
