<?php
#Poll Article directory for new articles, add them to the databse if they are not already there
include '/var/www/sites/isogen/assets/php/iso-includes/IsogenDatabase.php';

define("ARTICLE_PATH", "/var/www/sites/isogen/articles");

$directories = glob( ARTICLE_PATH . '/*' , GLOB_ONLYDIR);
$database = new IsogenDatabase();


foreach ($directories as $articleName) {
	$name = basename($articleName);
	if(!$database->checkExistsArticle($name)){
		$database->addArticle($name);
		echo "Added " . $name . " to the database.";
	}
}