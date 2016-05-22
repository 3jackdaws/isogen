<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 5/21/16
 * Time: 5:10 PM
 */

$article_name = $_POST["name"];

if(isset($article_name))
{
    $fname = "/var/www/sites/isogen/posts/articles/" . $article_name . "/" . $article_name . ".html";
    $file = fopen($fname, "r");
    $raw_article = fread($file, filesize($fname));
    preg_match("/(?<=#).+(?=#)/", $raw_article, $matches);
    $header_image_path = "/posts/articles/" . $article_name . "/" . $matches[0];
    $header_img_tag = "<div class='article-img' style=\"margin: 0 0 0px 0; background-image:url('" . $header_image_path . "')\"></div>";
    //unset($matches);
    preg_match("#<h1>.*</h1>#", $raw_article, $matches);
    $article_h1 = $matches[0];
    preg_match("#<h2>.*</h2>#",$raw_article, $matches);
    $article_h2 = $matches[0];


    $a_front_tag = "<article style=\"max-width: 700px; margin: 0 auto; font-size: 18px\">";
    $a_back_tag = "</article>";
    //echo $a_front_tag . $article_text . $a_back_tag;
    ?>


        <div class="post-card">
            <div class="overlay article-preload" preload="<?=$article_name?>"></div>
            <div class="img" style="background-image: url(<?=$header_image_path?>)"/>
            <br>
            <div class="container">
                <?=$article_h1?>
                <?=$article_h2?>
            </div>
        </div>



    <?php

}