<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 5/20/16
 * Time: 11:40 PM
 */

$article_link = $_POST["link"];

if(isset($article_link))
{
    $article_text;
    $raw_article = file_get_contents("http://" . $_SERVER["HTTP_HOST"] . "/" . $article_link);
    preg_match("/(?<=#).+(?=#)/", $raw_article, $matches);
    $header_image_path = dirname($article_link) . "/" . $matches[0];
    $header_img_tag = "<div class='article-img' style=\"margin: 0 0 0px 0; background-image:url('" . $header_image_path . "')\"></div>";
    echo $header_img_tag;
    $article_text = preg_replace("/#.+#/", "",$raw_article);


    $a_front_tag = "<article style=\"max-width: 700px; margin: 0 auto; font-size: 20px\">";
    $a_back_tag = "</article>";
    echo $a_front_tag . $article_text . $a_back_tag;
}




