<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/27/2016
 * Time: 7:56 PM
 */
include_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/account/ArticleParser.php");
include_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/DBArticle.php");
include_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/json_response.php");
$ap = new ArticleParser();
$article = $ap->parseMarkup("/account/temp");
$response = new json_response();
$upload_dir = realpath($_SERVER["DOCUMENT_ROOT"]) . "" . $article["publish-to"];
if(!mkdir($upload_dir)){
    $response["error"] = 1;
    $response["errorline"] = "Could not make directory";
}

$files = $_FILES["files"];
$num_files = count($files["name"]);
for ($i = 0; $i<$num_files; $i++){
    if($files["type"][$i] == "text/html"){
        move_uploaded_file($files["tmp_name"][$i], $upload_dir . "/markup.html");
    }else{
        move_uploaded_file($files["tmp_name"][$i], $upload_dir . "/".$files["name"][$i]);
    }
}
copy(realpath($_SERVER["DOCUMENT_ROOT"]) . "/account/temp/cp.php", $upload_dir . "/index.php");
$dba = new DBArticle();
if($dba->addArticle(basename($article["publish-to"]))){
    $response["message"] = "Article successfully published";
}
else{
    $response["error"] = 1;
    $response["errorline"][] = $dba->getError();
}

echo json_encode($response);