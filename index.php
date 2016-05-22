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

    <style>
        .article-img{
            background-size: cover;
            background-position: center center;
            width: 100%;
            height: 400px;
        }

        article{
            max-width: 700px;
            padding: 4%;
        }

        h2{
            font-size: 20px;
            font-style: oblique;
            color: lightgray;
        }

        .post-card{
            overflow: hidden;
            position: relative;
            text-align: left;
            border: 1px solid lightgray;
            border-radius: 6px;
            margin-bottom: 5%;
            background-color: #f7f7f7;
            box-shadow: 1px 1px 10px 5px #f5f5f5;
        }

        .post-card .img{
            width: 100%;
            height: 50%;
            min-height: 200px;
            background-size: cover;
        }

        .post-card .container{
            margin: 0 auto;
            padding: 5%;
            padding-top: 0%;
            width: 100%;
        }

        .post-card h1{
            font-size: 25px;
        }

        .post-card h2{
            font-size: 22px;
            color: grey;
        }
        .post-card .overlay{
            width: 100%;
            height: 100%;
            background-color: transparent;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <nav id="nav" class="navbar navbar-default" style="margin: 0;border-radius: 0;padding: 0 15% 0 15%;border-bottom: solid 0.5px lightgray">
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
                <li id="home" class="navlink"><a href="javascript:;">Home</a></li>
                <li id="posts" class="navlink"><a href="javascript:;">Posts</a></li>
                <li id="code" class="navlink"><a href="javascript:;">Code</a></li>
                <li id="about" class="navlink"><a href="javascript:;">About</a></li>
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