<?php
	function ArticleParser($article_name)
	{
		$article = [];
		$server_path = "/var/www/sites/isogen/";
		$article["text_path"] = $server_path . "posts/articles/" . $article_name . "/" . $article_name . ".html";
	    $file = fopen($article["text_path"], "r");
	    $article["text"] = fread($file, filesize($article["text_path"]));
	    preg_match("/(?<=#).+(?=#)/", $article["text"], $matches);
	    $article["header_image"] = "/posts/articles/" . $article_name . "/" . $matches[0];
	    $header_img_tag = "<div class='article-img' style=\"margin: 0 0 0px 0; background-image:url('" . $header_image_path . "')\"></div>";
	    //unset($matches);
	    preg_match("#<h1>.*</h1>#", $article["text"], $matches);
	    $article["h1"] = $matches[0];
	    preg_match("#<h2>.*</h2>#", $article["text"], $matches);
	    $article["h2"] = $matches[0];
	    preg_match("#(?<=\<author>).*(?=</author>)#", $raw_article, $matches);
	    $article["author"] = $matches[0];
	    


	    return $article;
	}
?>