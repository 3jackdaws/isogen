<?php
    $loadpage = $_GET["page"];
    $loadarticle = $_GET["article"];
    if(!isset($loadpage))
    {
        $loadpage = "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#FFFFFF">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="isogen">
    <meta name="description" content="The activities and projects of Ian Murphy">
    <meta name="author" content="Ian Murphy">
    <link rel="icon" href="">

    <title>
        Isogen
    </title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <style>
        
    </style>

</head> 

<body>
    <nav id="nav" class="navbar navbar-top navbar-default" style="margin: 0;border-radius: 0;padding: 0 15% 0 15%;border-bottom: solid 1px grey">
        <div class="navbar-header">
            <button type="button" onclick="collapse()" class="navbar-toggle collapsed" style="color:black" >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="font-size: 2em; font-family: serif;color: black;" href="#">ISOGEN</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li id="home" class="navlink iso-preload" preload="home" preload-class="navlink"><a href="javascript:;">Home</a></li>
                <li id="puzzles" class="navlink iso-preload" preload="puzzles" preload-class="navlink"><a href="javascript:;">Puzzles</a></li>
                <li id="about" class="navlink iso-preload" preload="about" preload-class="navlink"><a href="javascript:;">About</a></li>
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
    <div id="mainPageContainer" class="container-fluid" style="padding:0; margin: 0">

    </div>

    <script src="/assets/js/iso-preloading.js"></script>
    <script>

        function collapse(){
            var navbar = document.getElementById("navbar");
            var regex = new RegExp(" collapse");
            if(navbar.className.match(regex))
                navbar.className = navbar.className.replace(regex, "");
            else
                navbar.className += " collapse";
        }

        function articleULRDecoder(name){
            return "/articles/" + name;
        };

        function articleResourceDecoder(name){
            return "/assets/php/ArticleBuilder.php?name=" + name;
        }

        function navlinkURLDecoder(link){
            return link == "home" ? "/" : link;
            
        }

        function navlinkResourceDecoder(link){
            return "/" + link + "/" + link + ".php";
        }

        /* ========= SETUP =========== */
        iso.on("load", function(){
            iso.get(link, function(data){
                document.getElementById("mainPageContainer").innerHTML = data;
                history.pushState("page", null, url);
                iso.profile();
            });
        });
        iso.on("popstate", function(event){iso.onHistoryBackEvent(event)});
        iso.installPreloadClass("navlink", navlinkResourceDecoder, navlinkURLDecoder, "mainPageContainer");
        iso.installPreloadClass("article", articleResourceDecoder, articleULRDecoder,"mainPageContainer");
        var page = "<?=$loadpage?>";
        var article = "<?=$loadarticle?>";
        var link, url;

        if(page.length > 0){
            link = navlinkResourceDecoder(page);
            url = navlinkURLDecoder(page);
        } 
        else if(article.length > 0){
            link = articleResourceDecoder(article);
            url = articleULRDecoder(article);
        } 
        else{
            link = "/home/home.php";
            url = "/";
        }
    </script>
</body>