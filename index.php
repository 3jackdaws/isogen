<?php
    $basepath = realpath($_SERVER['DOCUMENT_ROOT']);
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
    <script src="/assets/js/std.js"></script>
    
    <script type="text/javascript">
        
    </script>


</head> 

<body>
    <?php
        include($basepath . '/assets/comp/navbar.html');
    ?>
    <div id="main" class="container-fluid" style="padding:0; margin: 0">
        <div id="featured-article">
            <?php
                include($basepath . "/assets/php/iso-includes/featured-article.php");
            ?>
        </div>

        <div id="card-div" class="container-fluid" style="max-width: 900px; padding: 0;">
            <?php  include( $basepath . "/assets/php/CardBuilder.php");
                GenerateCardsByKey();
            ?>
        </div>
    </div>
</body>
<script type="text/javascript">
    InstantClick.init();
</script>