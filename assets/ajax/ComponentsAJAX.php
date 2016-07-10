<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 7/7/16
 * Time: 8:23 PM
 * Purpose: This file serves as an wrapper around any of the isogen web classes that will allow access to them via AJAX.
 *          Access will be controlled via a permissions lookup.
 *
 */

require("../php/AuthModule.php");

$auth = new AuthModule();
$token = $_POST['token'];
$user_creds = json_decode($auth->loginFromToken($token));

if($user_creds["permissions"] !== 1) return;

$class = isset($_POST['class']) ? $_POST['class'] : $_GET['class'];

include_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/' . $class . '.php');


$instance = new $class();