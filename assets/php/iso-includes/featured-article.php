<?php
include_once("ArticleParser.php");
$handle = fopen($_SERVER['WEBROOT'] . "articles/latest.txt", "r");
$featured_article = fgets($handle);
$article = ArticleParser($featured_article);



?>
	
		<div class="img" style="background-image: url('<?=$article["header_image"]?>');"></div>
	
		<div class="placard">
			<div class="inner"></div>
			<div class="overlay iso-preload" preload="<?=$featured_article?>" preload-class="article"></div>
			<h1>
				<?=$article["h1"]?>
			</h1>
			<author><?=$article["author"]?></author> - <date><?=$article["date"]?></date>
			<h2>
				<?=$article["h2"]?>
			</h2>
		</div>
	

<?php
?>