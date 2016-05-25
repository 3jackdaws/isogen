<?php
include_once("ArticleParser.php");
$handle = fopen("/var/www/sites/isogen/posts/articles/latest.txt", "r");
$featured_article = fgets($handle);
$article = ArticleParser($featured_article);



?>
	
		<div class="img" style="background-image: url('<?=$article["header_image"]?>');"></div>
	
		<div class="placard">
			<div class="inner"></div>
			<div class="overlay article-preload" preload="<?=$featured_article?>"></div>
			<h1>
				<?=$article["h1"]?>
			</h1>
			<h2>
				<?=$article["h2"]?>
			</h2>
		</div>
	

<?php
?>