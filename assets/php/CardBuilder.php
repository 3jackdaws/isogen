<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 5/21/16
 * Time: 5:10 PM
 */
include_once "iso-includes/ArtileParser.php";
$article_name = $_POST["name"];

if(isset($article_name))
{
    $article = ArticleParser($article_name);
    ?>


        <div class="post-card">
            <div class="overlay iso-preload" preload="<?=$article_name?>" preload-class="article"></div>
            <div class="img" style="background-image: url(<?=$article["header_image"]?>)"></div>
            <br>
            <div class="container">
                <?=$article["h1"]?>
                <?=$article["h2"]?>
            </div>
        </div>



    <?php

}