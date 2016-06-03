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

    $a_front_tag = "<article >";
    $a_back_tag = "</article>";
    $a_hdr_frnt = "<div class='article-img' style=\"background-image: url('";
    $a_hdr_rear = "')\"></div>";
    echo $a_hdr_frnt . $article["header_image"] . $a_hdr_rear;
    echo $a_front_tag . 
    		"<h1>" . $article["h1"] . "</h1>" .
    		"<author>" . $article["author"] . "</author>" .
    		" - " .
    		"<date>" . $article["date"] . "</date>" . 
    		"<hr>" . 
    		"<h2>" . $article["h2"] . "</h2>" .
    		$article["text"] . 
    		"<hr>" . 
    	$a_back_tag;
}




