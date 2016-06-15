
var $ = {
	pcache: {},
	get: function(resource, callback){
		var x = new XMLHttpRequest();
    	x.onreadystatechange = function() { 
    		//console.log("xml: " + xmlHttp.readyState);
        	if (x.readyState == 4 && x.status == 200){
            	callback(x.responseText);
        	}
    	}
    	x.open("GET", resource, true); 
    	x.send(null);
	},
	load: function(e){
		console.log("Load " + e);
		document.body.innerHTML = $.pcache.replace("/body/", "");
		return false;
	},
	preload: function(e, callback){
		
		$.get(e.href, function(data){
			callback(data)
		});
	},
	cut: function(text){
		var pattern = /<body[^>]*>((.|[\n\r])*)<\/body>/im;
		return pattern.exec(text)
	},
	profile: function(){
		console.log("Profiling");
		var a = document.getElementsByTagName("A");
		console.log(a.length);
		for (var i = a.length - 1; i >= 0; i--) {
			console.log(a[i]);
			a[i].onmouseover = function(){$.preload(this, function(data){$.pcache=$.cut(data)})};
			a[i].onclick = function(){$.load(this)
				return false};
		}
	}
}