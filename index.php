<?php
require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/PagePrimitives.php");
$timer = new PageTimer();
$timer->start();
if(isset($_COOKIE["token"])){
    require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/AuthModule.php");
    $authmod = new AuthModule();
    $user = json_decode($authmod->loginFromToken($_COOKIE['token']));
}

?>
<html>
<head>
    <?php PagePrimitives::std_head()?>
</head>
<body>
<?php PagePrimitives::std_navbar(PagePrimitives::std_login_button($user->name))?>

    <div id="featured-article">
        <?php
        //include("featured-article.php");

        include(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/DBArticle.php");
        $db = new DBArticle();

        $art = $db->getFeaturedArticle();
        ?>
        <div class="img" style="background-image: url('<?=$art["image"]?>');"></div>

        <div class="placard">
            <div class="inner"></div>
            <a class="overlay" href="<?=$art['path']?>"></a>
            <h1>
                <?=$art["heading"]?>
            </h1>
            <author><?=$art["author"]?></author> - <date><?=$art["date"]?></date>
            <h2>
                <?=$art["subheading"]?>
            </h2>
        </div>

    </div>
<div class="container" style="width: 950px">
<?php

$articles = $db->getAllArticlesByDate(DBArticle::DESCENDING);
$cards = [];
for ($i = 0; $i<count($articles); $i++) {
    ob_start();
    ?>

    <div class="post-card ">
        <a class="overlay" href="<?= $articles[$i]["path"]?>"></a>
        <div class="img" style="background-image: url(<?= $articles[$i]['image'] ?>)"></div>
        <br>
        <div class="container">
            <h1><?= $articles[$i]["heading"] ?></h1>
            <center>
                <author><?= $articles[$i]["author"] ?></author>
                -
                <date><?= $articles[$i]["date"] ?></date>
            </center>
            <h2><?= $articles[$i]["subheading"] ?></h2>
        </div>
    </div>

    <?php
    $cards[$i%2] .= ob_get_clean();
}
echo "<div class='col-lg-6'>" . $cards[0] . "</div>";
echo "<div class='col-lg-6'>" . $cards[1] . "</div></div>";
?>
</div>

</body>
<?php
$timer->stop();
WebConsole::Log($timer);
