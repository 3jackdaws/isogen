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
    <nav id="nav" class="navbar navbar-fixed-top navbar-default" style="margin: 0;border-radius: 0;padding: 0 15% 0 15%;border-bottom: solid 1px grey">
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
    
    <div id="main" class="container-fluid" style="padding:0; margin: 0">
    </div>
</body>
<script type="text/javascript">
    $.get("/puzzles/puzzles.php", function(data){
        document.getElementById("main").innerHTML = data;
        InstantClick.init();
    });
    
</script>