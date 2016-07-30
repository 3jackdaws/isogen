<?php
require("../assets/php/json_response.php");

class ArticleParser
{
	private $_article = [];
	private $_webroot_path;
	private $_pathto;
	private $_errors;
	public function __construct()
	{
		$this->_webroot_path = realpath($_SERVER['DOCUMENT_ROOT']);
	}

	public function parseMarkup($web_path)
	{
		$path = $this->_webroot_path . $web_path;
		$this->_pathto = $path;
		$server_path = realpath($_SERVER['DOCUMENT_ROOT']);
		$this->_article["text_path"] = $path . "/markup.html";

		#Open and Read in File
		$file = fopen($this->_article["text_path"], "r");
		if($file === false) return false;
		$text = fread($file, filesize($this->_article["text_path"]));

		if(preg_match("#(?<=\<header>).*(?=</header>)#", $text, $matches) > 0){
			$this->_article["header_image"] = $path . "/" . $matches[0];
		}else{
			$this->_article["header_image"] = false;
		}
		$this->_article['basedir'] = $path .'/';




		if(preg_match("#(?<=\<h1>).*(?=</h1>)#", $text, $matches) > 0){
			$this->_article["h1"] = $matches[0];
		}else{
			$this->_article["h1"] = false;
		}

		if(preg_match("#(?<=\<short>).*(?=</short>)#", $text, $matches) > 0){
			$this->_article["name"] = $matches[0];
		}else{
			$this->_article["name"] = preg_replace("#[ ,.]#", "-", $this->_article['h1']);
		}

		if(preg_match("#(?<=\<h2>).*(?=</h2>)#", $text, $matches) > 0){
			$this->_article["h2"] = $matches[0];
		}else{
			$this->_article["h2"] = false;
		}

		if(preg_match("#(?<=\<author>).*(?=</author>)#", $text, $matches) > 0){
			$this->_article["author"] = $matches[0];
		}else{
			$this->_article["author"] = false;
		}

		if(preg_match("#(?<=\<date>).*(?=</date>)#", $text, $matches) > 0){
			$this->_article["date"] = $matches[0];
		}else{
			$this->_article["date"] = false;
		}

		preg_match("#(?<=\<article>)[\s\S]*(?=</article>)#", $text, $matches);
		$this->_article["text"] = $matches[0];
		preg_match_all("#(?<=\<img>).*?(?=</img>)#", $this->_article["text"], $matches);
		$this->_article["required_images"] = $matches[0];
		$this->_article["text"] = preg_replace('#<img>#', '<div class="ai-div"><img class="article-img" src="' . $this->_article['basedir'], $this->_article["text"]);
		$this->_article['text'] = preg_replace('#</img>#', '"/></div>', $this->_article['text']);

		$this->_article["publish-to"] = "/articles/" . preg_replace('# #', '-', $this->_article['h1']);
		return $this->_article;
	}

	public function checkErrors(){
		$this->_errors = new json_response();
		$provided_files = [];
		$files_in_dir = glob($this->_pathto . "/*");
		foreach ($files_in_dir as $file){
		    $provided_files[] = basename($file);
		}

		$required_files = [];
		$required_files[] = "markup.html";
		$required_files[] = basename($this->_article["header_image"]);
		foreach ($this->_article["required_images"] as $img){
		    $required_files[] = $img;
		}
		$missing_files = array_diff($required_files, $provided_files);
		foreach ($missing_files as $missing_file) {
		    $this->_errors->add_error("Missing file: " . $missing_file);
		}
		foreach ($this->_article as $key => $value) {
			if($key == "required_images"){
				continue;
			}
			if(!$value){
				$this->_errors->add_error($key . " tag not set");
			}
		}
	}

	public function getErrorsAsJSON(){
		return $this->_errors;
	}
}