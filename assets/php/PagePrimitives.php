<?php

/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/26/2016
 * Time: 11:54 AM
 */
class PagePrimitives
{
    
    public static function std_head($title = "Isogen",$script_src = array()){

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
            <?=$title?>
        </title>

        <link href="/assets/css/bootstrap.css" rel="stylesheet">
        <link href="/assets/css/custom.css" rel="stylesheet">
        <script src="/assets/js/instaclick.js" data-no-instant></script>

        <script src="/assets/js/std.js"></script>
        <?php
        foreach($script_src as $src){
            if(strpos($src, ".js") != false){
                echo "<script src=\"" . $src . "\"></script>";
            }
            elseif(strpos($src, ".css") != false){
                echo "<link href=\"" . $src . "\" rel=\"stylesheet\">";
            }
            else{
                echo "<style>" . $src . "</style>";
            }

        }
        ?>
        </head>
        <body>
        <?php
    }
    public static function std_navbar($name = "<a href='/account/'>Log In</a>"){
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
                    <li id="home" class="navlink"><a href="/">Home</a></li>
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
                            <?=$name?>
                        </p>
                    </li>
                </ul>
            </div>
        </nav>

        <?php
    }
    public static function std_article($aname, $full_path = false){
        include_once("ArticleParser.php");
        if(isset($aname))
        {
            $article = ArticleParser($aname, $full_path);

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
    public static function std_page($title = "Isogen", $script_src = array(),$name){
        self::std_head($title, $script_src);
        self::std_navbar($name);
    }
    public static function named_login($name){
        if(strlen($name) > 0)
            return "<a href=\"/account/\" class=\"btn btn-primary\">" . $name . "'s Account</a>";
        return "<a href=\"/account/\" class=\"btn btn-primary\">Log In</a>";
    }
}

class PageTimer{
    private $start_time;
    private $end_time;
    private $timer_group = [];
    public function start(){
        $this->start_time = microtime(true);
    }
    public function stop(){
        $this->end_time = microtime(true);
        return $this->end_time - $this->start_time;
    }

    public function __toString()
    {
        return json_encode($this->timer_group);
    }

    public function build($key, $value){
        $this->timer_group[$key] = $value;
    }
}

class WebConsole{
    public static function Log($string){
        echo '<script>console.log("' . $string . '")</script>';
    }

    public static function Error($string){
        echo '<script>console.error("' . $string . '")</script>';
    }

    public static function EchoLog($string){
        echo "<span class='php_error'>" . $string . "</span><br/>";
    }
}