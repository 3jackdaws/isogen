/**
 * Created by Ian Murphy on 6/15/2016.
 */
var $ = {
    get: function (r, c) {
        var x=new XMLHttpRequest();
        x.onreadystatechange=function(){if(x.readyState==4&&x.status==200)c(x.responseText);}
        x.open("GET", r, true);
        x.send(null);
    },
    collapse: function(){
    var navbar = document.getElementById("navbar");
    var regex = new RegExp(" collapse");
    if(navbar.className.match(regex))
        navbar.className = navbar.className.replace(regex, "");
    else
        navbar.className += " collapse";
    },
    post: function(r,p,c){
        var x=new XMLHttpRequest();
        x.onreadystatechange=function(){if(x.readyState==4&&x.status==200)c(x.responseText);}
        x.open("POST", r, true);
        // x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        x.send(p);
    },
    post2: function(r,p,c){
        var x=new XMLHttpRequest();
        x.onreadystatechange=function(){if(x.readyState==4&&x.status==200)c(x.responseText);}
        x.open("POST", r, true);
        x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        x.send(p);
    },
    setCookie: function(cname, cvalue, exdays) {
        if(exdays == null){
            document.cookie = cname + "=" + cvalue + ";path=/";
        }else{
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";
        }
    }
    
}