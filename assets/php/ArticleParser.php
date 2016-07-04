<?php
//	function ArticleParser($article_name, $fullpath = false)
//	{
//
//		if($fullpath){
//			$path = $article_name;
//		}
//		else{
//			$path = "/articles/" . $article_name;
//		}
//
//		$article["name"] = basename($article_name);
//		$server_path = realpath($_SERVER['DOCUMENT_ROOT']);
//		$article["text_path"] = $server_path . $path . "/markup.html";
//
//		#Open and Read in File
//	    $file = fopen($article["text_path"], "r");
//		if($file === false) return false;
//	    $text = fread($file, filesize($article["text_path"]));
//
//	    preg_match("#(?<=\<header>).*(?=</header>)#", $text, $matches);
//	    $article["header_image"] = $path . "/" . $matches[0];
//	    $article['basedir'] = $path .'/';
//
//	    preg_match("#(?<=\<h1>).*(?=</h1>)#", $text, $matches);
//	    $article["h1"] = $matches[0];
//
//	    preg_match("#(?<=\<h2>).*(?=</h2>)#", $text, $matches);
//	    $article["h2"] = $matches[0];
//
//	    preg_match("#(?<=\<author>).*(?=</author>)#", $text, $matches);
//	    $article["author"] = $matches[0];
//
//	    preg_match("#(?<=\<date>).*(?=</date>)#", $text, $matches);
//	    $article["date"] = $matches[0];
//
//	    preg_match("#(?<=\<article>)[\s\S]*(?=</article>)#", $text, $matches);
//	    $article["text"] = preg_replace('#<img>#', '<div class="ai-div"><img class="article-img" src="' . $article['basedir'], $matches[0]);
//	    $article['text'] = preg_replace('#</img>#', '"/></div>', $article['text']);
//
//		$article["publish-to"] = "/articles/" . preg_replace('# #', '-', $article['h1']);
//	    return $article;
//	}

function ArticleParser($article_name, $fullpath = false)
{

	if($fullpath){
		$path = $article_name;
	}
	else{
		$path = "/articles/" . $article_name;
	}

	$article["name"] = basename($article_name);
	$server_path = realpath($_SERVER['DOCUMENT_ROOT']);
	$article["text_path"] = $server_path . $path . "/markup.html";

	#Open and Read in File
	$file = fopen($article["text_path"], "r");
	if($file === false) return false;
	$text = fread($file, filesize($article["text_path"]));

	if(preg_match("#(?<=\<header>).*(?=</header>)#", $text, $matches) > 0){
		$article["header_image"] = $path . "/" . $matches[0];
	}else{
		$article["header_image"] = false;
	}
	$article['basedir'] = $path .'/';

	if(preg_match("#(?<=\<h1>).*(?=</h1>)#", $text, $matches) > 0){
		$article["h1"] = $matches[0];
	}else{
		$article["h1"] = false;
	}


	if(preg_match("#(?<=\<h2>).*(?=</h2>)#", $text, $matches) > 0){
		$article["h2"] = $matches[0];
	}else{
		$article["h2"] = false;
	}

	if(preg_match("#(?<=\<author>).*(?=</author>)#", $text, $matches) > 0){
		$article["author"] = $matches[0];
	}else{
		$article["author"] = false;
	}

	if(preg_match("#(?<=\<date>).*(?=</date>)#", $text, $matches) > 0){
		$article["date"] = $matches[0];
	}else{
		$article["date"] = false;
	}

	preg_match("#(?<=\<article>)[\s\S]*(?=</article>)#", $text, $matches);
	$article["text"] = $matches[0];
	preg_match_all("#(?<=\<img>).*?(?=</img>)#", $article["text"], $matches);
	$article["required_images"] = $matches[0];
	$article["text"] = preg_replace('#<img>#', '<div class="ai-div"><img class="article-img" src="' . $article['basedir'], $article["text"]);
	$article['text'] = preg_replace('#</img>#', '"/></div>', $article['text']);

	$article["publish-to"] = "/articles/" . preg_replace('# #', '-', $article['h1']);
	return $article;
}
?>