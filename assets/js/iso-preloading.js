/*

ISOGEN Preloading Library
Author: Ian Murphy


USE:

All preload elements must have class "iso-preload".
All preload elements must have a preload handler installed: iso.installPreloadClass("classname", lambda-preload-decoder, "dividtoswapto")
All preload elements must have a preload attribute with the id or whatever.
All preload elements must have a preload-class attribute.

For example, all articles are stored in the /articles/ directory.

iso.installPreloadCLass("article", function(name){
	return "/articles/" + name + ".html";
}, "putarticlehere");

<div id="putarticlehere" class="iso-preload" preload="article-name" preload-class="article"></div>

No event handlers, nothing else.  Install your preload class and do some preloading.
\

*/



var iso = {

	PARENT: "iso",
   	allPreElem: [],
   	cachedPreloadData: {},
   	preloadingElement: {},	
   	loadToElement:{},
   	preloadClass: [],
   	preloadURL: "",
   	preloadResource: "",

   	isoOnLoad: function(){},
	
   	customPreloadDecoder: function(str){
		return str;
	},

	
   	getPreloadElements: function(){
		iso.allPreElem = document.getElementsByClassName("iso-preload");
		while(iso.allPreElem.length>0) {
			
			iso.allPreElem[0].addEventListener("mouseover", function(){iso.hoverEvent(this)});
			iso.allPreElem[0].addEventListener("mousedown", function(){iso.clickEvent(this)});
			iso.allPreElem[0].className = iso.allPreElem[0].className.replace(new RegExp("iso-preload"), "");
		};
	},

	profile: function(){
		var preSize = iso.allPreElem.length;
		this.getPreloadElements();
		//console.log("Profiling: Added " + (iso.allPreElem.length - preSize) + " new nodes, total " + iso.allPreElem.length);
	},

	hoverEvent: function(element, onLoadedEvent){
		var pClassInfo = this.preloadClass[element.getAttribute("preload-class")];
		if(pClassInfo == null){ 
			console.error("You must install a preload class using iso.installPreloadClass before preloading can be done.");
			return;
		}
		else{
			var resourceDecoder = pClassInfo[0];
			var bookmarkDecoder = pClassInfo[1];
			this.loadToElement = document.getElementById(pClassInfo[2]);
			
			var rawResource = element.getAttribute("preload");
			preloadResource = resourceDecoder(rawResource);
			if(this.preloadingElement === element) return;

			preloadingElement = element;
			this.get(preloadResource, function(data){
				cachedPreloadData = data;
				preloadingElement.setAttribute("loaded", "true");
				preloadURL = bookmarkDecoder(rawResource);
				if(onLoadedEvent != null) onLoadedEvent();
			});
		}
	},

	clickEvent: function(element){
		console.log("Click");
		if(element.getAttribute("loaded") == "true"){
			iso.swapPage();
		}
		else{
			this.hoverEvent(element, function(){
				iso.swapPage();
			});
		}
		
		
	},

	swapPage: function(){
		this.loadToElement.innerHTML = cachedPreloadData;
		history.pushState("null", null, preloadURL);
		console.log("Push: " + preloadURL);
		iso.scrollToTop(300);
		iso.profile();
	},

	installPreloadClass: function(classname, resourceDecoder, bookmarkDecoder, insertid){
		
		this.preloadClass[classname] = new Array(resourceDecoder, bookmarkDecoder, insertid);
	},
	
	get: function(resource, callback){
		var xmlHttp = new XMLHttpRequest();
    	xmlHttp.onreadystatechange = function() { 
    		//console.log("xml: " + xmlHttp.readyState);
        	if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
        		//console.log(xmlHttp.responseText);
            	callback(xmlHttp.responseText);
        	}
    	}
    	xmlHttp.open("GET", resource, true); 
    	xmlHttp.send(null);
	},

	onload: function(userdef){
		window.addEventListener("load", userdef);
	},

	onHistoryBackEvent: function(data){
		if(data.state != null){
			window.location = window.location.pathname;
		}
	},

	on: function(listener, onEvent){
		window.addEventListener(listener, onEvent);
	},

	scrollToTop: function(scrollDuration) {
        const   scrollHeight = window.scrollY,
                scrollStep = Math.PI / ( scrollDuration / 15 ),
                cosParameter = scrollHeight / 2;
        var     scrollCount = 0,
                scrollMargin,
                scrollInterval = setInterval( function() {
                    if ( window.scrollY != 0 ) {
                        scrollCount = scrollCount + 1;  
                        scrollMargin = cosParameter - cosParameter * Math.cos( scrollCount * scrollStep );
                        window.scrollTo( 0, ( scrollHeight - scrollMargin ) );
                    } 
                    else clearInterval(scrollInterval); 
                }, 15 );
        }
}

