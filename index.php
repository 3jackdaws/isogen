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
    <nav id="nav" class="navbar navbar-fixed-top navbar-default" style="margin: 0;border-radius: 0;padding: 0 15% 0 15%;border-bottom: solid 0.5px lightgray">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" style="color:black" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar" style="color: #000;"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="font-size: 2em; font-family: serif;color: black;" href="#">ISOGEN</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li id="home" class="navlink"><a href="#">Home</a></li>
                <li id="puzzles" class="navlink"><a href="#">Puzzles</a></li>
                <li id="about" class="navlink"><a href="#">About</a></li>
                <li class=""><a href="mailto:3jackdaws@gmail.com">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li id="ddown">
                    <form class="navbar-form form-inline">
                        <input class="form-control" name="search-query" placeholder="Search Posts"/>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div id="mainPageContainer" class="container-fluid" style="padding:0; margin: 0">

    </div>


    <script>
        var page = "<?=$loadpage?>";
        var article = "<?=$loadarticle?>";
    </script>
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/custom.js"><</script>
</body>