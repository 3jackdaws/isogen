<?php
include_once("ArticleParser.php");
$handle = fopen($_SERVER['WEBROOT'] . "articles/latest.txt", "r");
$featured_article = fgets($handle);
$article = ArticleParser($featured_article);



?>
	
		<div class="img" style="background-image: url('<?=$article["header_image"]?>');"></div>
	
		<div class="placard">
			<div class="inner"></div>
			<a class="overlay" href="/articles/<?=$featured_article?>"></a>
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