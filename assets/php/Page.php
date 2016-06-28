<?php

/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/15/2016
 * Time: 8:39 PM
 */
class ArticlePage extends AbstractPage{
    protected $_article_name;
    public function __construct($name)
    {
        $this->_article_name = $name;
    }

    public function setArticleName($name){
        $this->_article_name = $name;
    }
    public function writeBody()
    {
        include_once("ArticleParser.php");
        if(isset($this->_article_name))
        {
            $article = ArticleParser($this->_article_name);

            $a_front_tag = "<article >";
            $a_back_tag = "</article>";
            $a_hdr_frnt = "<div class='header-img' style=\"background-image: url('";
            $a_hdr_rear = "')\"></div>";
            echo $a_hdr_frnt . $article["header_image"] . $a_hdr_rear;
            echo $a_front_tag .
                "<h1>" . $article["h1"] . "</h1>" .
                "<h2>" . $article["h2"] . "</h2>" .
                "<hr>" .
                "<author>" . $article["author"] . "</author>" .
                " - " .
                "<date>" . $article["date"] . "</date>" .
                $article["text"] .
                "<hr>" .
                $a_back_tag;
        }
    }
    public function createPage()
    {
        $this->writeHead();
        $this->writeNavbar();
        $this->writeBody();
        $this->writeFooter();
    }
}

class MainPage extends AbstractPage{
    public function writeBody()
    {
        ?>
        <div id="featured-article">
            <?php
            //include("featured-article.php");

            include("DBArticle.php");
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
            include("CardBuilder.php");
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


                </div>
                <?php
                $cards[$i%2] .= ob_get_clean();
            }
            echo "<div class='col-lg-6'>" . $cards[0] . "</div>";
            echo "<div class='col-lg-6'>" . $cards[1] . "</div></div>";
    }
    public function createPage()
    {
        
        $this->writeHead();
        $this->writeNavbar();
        $this->writeBody();
        $this->writeFooter();
        
    }
}

class CustomPage extends AbstractPage{
    private $_createHeadFunc;
    private $_createNavbarFunc;
    private $_createBodyFunc;
    private $_createFooterFunc;
    public function setCustomBody($func){
        $this->_createBodyFunc = $func;
    }
    public function writeHead()
    {
        if($this->_createHeadFunc == null)
            parent::writeHead();
        else{
            $this->_createHeadFunc();
        }
    }

    public function writeBody()
    {
        if($this->_createBodyFunc == null)
            parent::writeBody();
        else{
            $this->_createBodyFunc->__invoke();
        }
    }

    public function createPage()
    {
        $this->writeHead();
        $this->writeNavbar();
        $this->writeBody();
        $this->writeFooter();
    }
}

class AbstractPage
{
    public function writeHead(){
        ?>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="theme-color" content="#FFFFFF">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="The activities and projects of Ian Murphy">
            <meta name="author" content="Ian Murphy">
            <meta name="version" content="1.6.6">
            <link rel="icon" href="">
            <title>
                Isogen
            </title>

            <link href="/assets/css/bootstrap.css" rel="stylesheet">
            <link href="/assets/css/custom.css" rel="stylesheet">
            <script src="/assets/js/instaclick.js" data-no-instant></script>

            <script src="/assets/js/std.js"></script>
            <script type="text/javascript">
                function collapse(){
                    var navbar = document.getElementById("navbar");
                    var regex = new RegExp(" collapse");
                    if(navbar.className.match(regex))
                        navbar.className = navbar.className.replace(regex, "");
                    else
                        navbar.className += " collapse";
                }
            </script>
        </head>
        <body>
        <?php
    }
    public function writeNavbar(){
        ?>
            <nav id="nav" class="navbar navbar-fixed-top navbar-default" style="margin: 0;border-radius: 0;padding: 0 15% 0 15%;border-bottom: solid 1px grey">
                <div class="navbar-header">
                    <button type="button" onclick="$.collapse()" class="navbar-toggle collapsed" style="color:black" >
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" style="font-size: 2em; font-family: serif;color: black;" href="/">ISOGEN</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id="home" class="navlink active"><a href="/">Home</a></li>
                        <li id="puzzles" class="navlink"><a href="/puzzles">Puzzles</a></li>
                        <li id="projects" class="navlink"><a href="/projects">Projects</a></li>
                        <li id="about" class="navlink"><a href="/about">About</a></li>
                        <li class=""><a href="mailto:3jackdaws@gmail.com">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form class="navbar-form form-inline">
                                <input class="form-control" name="search" placeholder="Search Posts"/>
                            </form>
                        </li>
                        <li>
                            <p class="navbar-btn">
                                <a href="/login/" class="btn btn-primary">Log In</a>
                            </p>
                        </li>
                    </ul>
                </div>
            </nav>
        <?php
    }
    public function writeBody(){
        echo "<h1>NotImplemented</h1><h2>Please contact the webmaster</h2>";
    }
    public function writeFooter(){
        ?>
        </body>
        <script type="text/javascript">
            InstantClick.init();
        </script>
        <?php
    }
    public function createPage(){
        $this->writeHead();
        $this->writeNavbar();
        $this->writeBody();
        $this->writeFooter();
    }
}








