<?php
	function ArticleParser($article_name)
	{
		$article = [];
		$server_path = "/var/www/sites/isogen/";
		$article["text_path"] = $server_path . "articles/" . $article_name . "/markup.html";
	    $file = fopen($article["text_path"], "r");
	    $article["text"] = fread($file, filesize($article["text_path"]));
	    preg_match("/(?<=#).+(?=#)/", $article["text"], $matches);
	    $article["header_image"] = "/articles/" . $article_name . "/" . $matches[0];
	    $article["header_img_div"] = "<div class='article-img' style=\"margin: 0 0 0px 0; background-image:url('" . $article["header_image"] . "')\"></div>";
	    //unset($matches);
	    preg_match("#<h1>.*</h1>#", $article["text"], $matches);
	    $article["h1"] = $matches[0];
	    preg_match("#<h2>.*</h2>#", $article["text"], $matches);
	    $article["h2"] = $matches[0];
	    preg_match("#(?<=\<author>).*(?=</author>)#", $raw_article, $matches);
	    $article["author"] = $matches[0];
	    $article["text"] = preg_replace("/#.+#/", "", $article["text"]);
	    


	    return $article;
	}
?>