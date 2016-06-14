<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 5/21/16
 * Time: 5:10 PM
 */
include_once "iso-includes/ArticleParser.php";
include_once "iso-includes/IsogenDatabase.php";
define("ARTICLE_PATH", $_SERVER['WEBROOT'] . "articles");

function GenerateCardFromName($name)
{
    $article = ArticleParser($name);
    ob_start();
    ?>
    <div class="post-card">
        <div class="overlay" href="/articles/<?=$article_name?>"></div>
        <div class="img" style="background-image: url(<?=$article["header_image"]?>)"></div>
        <br>
        <div class="container">
            <?=$article["h1"]?>
            <?=$article["h2"]?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function GenerateCardFromArticleArray($article)
{
    ob_start();
    ?>
    <div class="post-card ">
        <div class="overlay" onclick="javascript:window.location='/articles/<?=$article["name"]?>'"></div>
        <div class="img" style="background-image: url(<?=$article['header_image']?>)"></div>
        <br>
        <div class="container">
            <h1><?=$article["h1"]?></h1>
            <center><author><?=$article["author"]?></author> - <date><?=$article["date"]?></date></center>
            <h2><?=$article["h2"]?></h2>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


function GenerateCardsByKey($num, $orderBy, $searchKey){
    
    $directories = glob( ARTICLE_PATH . '/*' , GLOB_ONLYDIR);
    $num_articles = count($directories);
    //var_dump($num_articles);

    for ($i = 0; $i<$num_articles; $i++){
        $article_names[$i] = basename($directories[$i]);
        $article_array[$i] = ArticleParser($article_names[$i]);
    }
    //echo count($article_array);
    foreach ($article_array as $article) {
        $date_article[strtotime($article["date"])] = $article;
    }

    
    krsort($date_article);
    //`var_dump(count($date_article));
    //var_dump(array_shift($date_article));
    for ($i=count($date_article); $i > 0; $i--) { 
        $column[$i%2] .= GenerateCardFromArticleArray(array_shift($date_article));
    }
    //var_dump(count($column));
    for ($i = 0; $i<count($column); $i++){
        ?>
        <div class="col-lg-6">
            <?=$column[$i]?>
        </div>
        <?php
    }
}

?>