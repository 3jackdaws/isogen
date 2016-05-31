<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 5/20/16
 * Time: 11:40 PM
 */
include_once("iso-includes/ArticleParser.php");
$article_name = $_GET["name"];

if(isset($article_name))
{
    $article = ArticleParser($article_name);
    $a_front_tag = "<article style=\"max-width: 700px; margin: 0 auto; font-size: 20px\">";
    $a_back_tag = "</article>";
    echo $article["header_img_div"];
    echo $a_front_tag . $article["text"] . "<hr>" . $a_back_tag;
}




