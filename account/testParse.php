<?php

include "ArticleParser.php";

$parser = new ArticleParser();
$article = $parser->parseMarkup("/articles/C-One-Liners");
