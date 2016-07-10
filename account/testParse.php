<?php

include "ArticleParser.php";

$parser = new ArticleParser();
$article = $parser->parseMarkup("/articles/Runaway-Robots-and-Runaway-Threads");
var_dump($article);