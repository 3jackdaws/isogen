<?php
include "/var/www/confidential/iso_sql.php";
include_once "/var/www/sites/isogen/assets/php/iso-includes/ArticleParser.php";
class IsogenDatabase{
	public $_connection;


	public function __construct(){
		$this->_connection = new mysqli("localhost", "iso_usr", ISO_SQL_PASS, "isogen");
		date_default_timezone_set('America/Los_Angeles');
	}

	public function addArticle($articleShort){
		
		$article = ArticleParser($articleShort);
		$result = $this->_connection->query("SELECT short_path FROM iso_articles;");
		$articleNames = $result->fetch_array();
		if(in_array($articleShort, $articleNames)) return;
		
		$sqlStatement = "INSERT INTO iso_articles (title, subheading, author, date_posted, date_altered, short_path, web_path) VALUES(?, ?, ?, ?, ?, ?, ?);";
		$boundStatement = $this->_connection->prepare($sqlStatement);
		if($boundStatement == false){
			echo "Error";
			return;
		}
		$title = $article["h1"];
		$subheading = $article["h2"];
		$author = $article["author"];
		$datePosted = date('Y-m-d G:i:s');
		$shortPath = $articleShort;
		$webPath = "/articles/" . $articleShort ;
		$boundStatement->bind_param("sssssss", $title, $subheading, $author, $datePosted, $datePosted, $shortPath, $webPath);
		$boundStatement->execute();
	}

	public function getArticleDBInformation(){
		$sqlStatement = "SELECT * FROM iso_articles;";
		$result = $this->_connection->query($sqlStatement);
		$articles = $result->fetch_array();
		return $articles;
	}

	public function checkExistsArticle($articleShortname){
		$sqlStatement = "SELECT short_path FROM iso_articles WHERE short_path = ?;";
		$prep = $this->_connection->prepare($sqlStatement);
		$prep->bind_param("s", $articleShortname);
		$prep->execute();
		$result = $prep->get_result();
		return count($result->fetch_array()) > 0;
	}
}