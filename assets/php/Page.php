<?php

/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/15/2016
 * Time: 8:39 PM
 */
namespace Page{
    

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
            include_once("iso-includes/ArticleParser.php");
            if(isset($this->_article_name))
            {
                $article = ArticleParser($this->_article_name);

                $a_front_tag = "<article >";
                $a_back_tag = "</article>";
                $a_hdr_frnt = "<div class='article-img' style=\"background-image: url('";
                $a_hdr_rear = "')\"></div>";
                echo $a_hdr_frnt . $article["header_image"] . $a_hdr_rear;
                echo $a_front_tag .
                    "<h1>" . $article["h1"] . "</h1>" .
                    "<author>" . $article["author"] . "</author>" .
                    " - " .
                    "<date>" . $article["date"] . "</date>" .
                    "<hr>" .
                    "<h2>" . $article["h2"] . "</h2>" .
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
            include_once("iso-includes/ArticleParser.php");
            ?>
            <div id="featured-article">
                <?php
                $handle = fopen(realpath($_SERVER['DOCUMENT_ROOT']) . "/articles/latest.txt", "r");
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
            </div>
            <div id="card-div" class="container-fluid" style="max-width: 900px; padding: 0;">
                <?php
                include("CardBuilder.php");
                GenerateCardsByKey();
                ?>
            </div>
            <?php
        }
        public function createPage()
        {
            $this->writeHead();
            $this->writeNavbar();
            $this->writeBody();
            $this->writeFooter();
        }
    }
    
    abstract class AbstractPage
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
                <link rel="icon" href="">
                <title>
                    Isogen
                </title>

                <link href="/assets/css/bootstrap.css" rel="stylesheet">
                <link href="/assets/css/custom.css" rel="stylesheet">
                <script src="/assets/js/instaclick.js" data-no-instant></script>

                <script src="/assets/js/ip2.js"></script>
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
                            <li id="about" class="navlink"><a href="/about">About</a></li>
                            <li class=""><a href="mailto:3jackdaws@gmail.com">Contact</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <form class="navbar-form form-inline">
                                    <input class="form-control" name="search" placeholder="Search Posts"/>
                                </form>
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
}







