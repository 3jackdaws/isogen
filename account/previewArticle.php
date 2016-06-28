<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/26/2016
 * Time: 4:21 PM
 */

$article["name"] = $article_name;
$server_path = realpath($_SERVER['DOCUMENT_ROOT']);
$article["text_path"] = $server_path . "./prev/markup.html";

#Open and Read in File
$file = fopen($article["text_path"], "r");
if($file === false) return false;
$text = fread($file, filesize($article["text_path"]));

preg_match("#(?<=\<header>).*(?=</header>)#", $text, $matches);
$article["header_image"] = "./prev/" . $matches[0];
$article['basedir'] = './prev/';

preg_match("#(?<=\<h1>).*(?=</h1>)#", $text, $matches);
$article["h1"] = $matches[0];

preg_match("#(?<=\<h2>).*(?=</h2>)#", $text, $matches);
$article["h2"] = $matches[0];

preg_match("#(?<=\<author>).*(?=</author>)#", $text, $matches);
$article["author"] = $matches[0];

preg_match("#(?<=\<date>).*(?=</date>)#", $text, $matches);
$article["date"] = $matches[0];

preg_match("#(?<=\<article>)[\s\S]*(?=</article>)#", $text, $matches);
$article["text"] = preg_replace('#<img>#', '<div class="ai-div"><img class="article-img" src="' . $article['basedir'], $matches[0]);
$article['text'] = preg_replace('#</img>#', '"/></div>', $article['text']);


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