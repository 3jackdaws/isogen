<?php
	function ArticleParser($article_name)
	{
		$article["name"] = $article_name;
		$server_path = realpath($_SERVER['DOCUMENT_ROOT']);
		$article["text_path"] = $server_path . "/articles/" . $article_name . "/markup.html";

		#Open and Read in File
	    $file = fopen($article["text_path"], "r");
	    $text = fread($file, filesize($article["text_path"]));

	    preg_match("#(?<=\<header>).*(?=</header>)#", $text, $matches);
	    $article["header_image"] = "/articles/" . $article_name . "/" . $matches[0];
	    $article['basedir'] = '/articles/' . $article_name . '/';
	   	
	    preg_match("#(?<=\<h1>).*(?=</h1>)#", $text, $matches);
	    $article["h1"] = $matches[0];

	    preg_match("#(?<=\<h2>).*(?=</h2>)#", $text, $matches);
	    $article["h2"] = $matches[0];

	    preg_match("#(?<=\<author>).*(?=</author>)#", $text, $matches);
	    $article["author"] = $matches[0];

	    preg_match("#(?<=\<date>).*(?=</date>)#", $text, $matches);
	    $article["date"] = $matches[0];

	    preg_match("#(?<=\<article>)[\s\S]*(?=</article>)#", $text, $matches);
	    $article["text"] = preg_replace('#<img>#', '<img class="article-img" src="' . $article['basedir'], $matches[0]);
	    $article['text'] = preg_replace('#</img>#', '"/>', $article['text']);
	    


	    return $article;
	}
?>