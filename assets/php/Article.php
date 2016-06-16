<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/15/2016
 * Time: 8:37 PM
 */
    $basepath = realpath($_SERVER['DOCUMENT_ROOT']);
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#FFFFFF">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The activities and projects of Ian Murphy">
    <meta name="author" content="Ian Murphy">
    <link rel="icon" href="">
    <title>
        Isogen
    </title>
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
    <script src="/assets/js/instaclick.js" data-no-instant></script>
    <script src="/assets/js/ip2.js"></script>
</head>

<body>
<?php
    include($basepath . '/assets/comp/navbar.html');
?>

<div id="main" class="container-fluid" style="padding:0; margin: 0">
    <?php
    $_GET['name'] = basename(__DIR__);
    include($basepath . '/assets/php/ArticleBuilder.php');
    ?>
</div>
</body>