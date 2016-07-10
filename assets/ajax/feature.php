<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 7/7/16
 * Time: 8:38 PM
 */

require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/AuthModule.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/json_response.php');
$response = new json_response();
$token = $_POST['token'];
$id = $_POST['id'];
$auth = new AuthModule();
if(!$auth->permLevel($token, 1)){
    $response->add_error("Insufficient Priveleges");
    echo $response;
}

require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/DBArticle.php');

$db = new DBArticle();
$db->setFeaturedArticle($id);

