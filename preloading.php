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
    <script src="/assets/js/iso-preloading.js"></script>
    <style>
        
    </style>

</head> 

<body>

<a class="iso-preload" preload="README.md" preload-id="main" href="javascript:;" >Preload this</a>
<a class="iso-preload article-preload" preload="preloading-articles" preload-class="article-preload">Preloading arts</a>

<div class="" id="main"></div>

<script type="text/javascript">
    function articleDecoder(art){
        return "/articles/" + art + "/" + art + ".html";
    }

    iso.onload(function(){
        console.log("Userdef");
        iso.installPreloadClass("article-preload", articleDecoder, "main");
    });
</script>