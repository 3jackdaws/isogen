/**
 * Created by ian on 5/20/16.
 */
var preloadPageData;
var siteSection;

function loadPage(page) {
    var path = getURL(page);
    $.get(path, function (data) {
        $("#mainPageContainer").html(data);
        updatePage();
    });
}

function preloadPage(element){
    var fname= element.children()[0].innerHTML.toLowerCase();
    var path = getURL(fname);
    if($(this).hasClass("loaded"))
    {

    }else{
        $(".loaded").removeClass("loaded");
        $.get(path, function (data) {
            preloadPageData = data;
            //updatePage();
            element.removeClass("lock");
            element.addClass("loaded");
        });
    }
}

// function openArticle(card){
//     var article = card.attr("preload");
//     alert(article);
// }

function getURL(file){
    return '/' + file + '/' + file + ".php";
}

function getArticlePath(article) {
    return "/articles/" + article + "/" + article + ".html";
}

function getArticleBookmarkPath(article) {
    return "/articles/" + article;
}

function buildArticle(name, onPreloadEvent){
    //var link = getArticlePath(name);
    $.post("/assets/php/ArticleBuilder.php", { name: name}, function (data) {
        preloadPageData = data;
        onPreloadEvent();
    });
}

function loadPageOnBack(href){
    if(new RegExp("articles").test(href))
    {
        var article = href.replace(new RegExp("/.*articles/"), "")
        buildArticle(article, function () {
            $("#mainPageContainer").html(preloadPageData);
            updatePage(getArticleBookmarkPath(article));
        });
    }
    else{
        var page = href.match(new RegExp("[a-zA-Z]+"));
        if(page == null)
        {
            page = "home";
        }
        console.log(page);
        loadPage(page);
    }
}

function updatePage(url)
{
    //console.log(url);
    //if(url == "/home") url == "/";
    //if(url != null) history.pushState('data', null, url);
    var path = url != null? url : "/";//window.location.pathname;
    if(path !== "/") {
        //console.log(path);
        siteSection = path.match(new RegExp("[a-z]+"));
        //console.log(siteSection);
    }
    else{
        siteSection = "home";
        //console.log(path);
    }
    //window.scrollTo(0, 0);
    history.pushState('data', null, path);
    $("li.navlink").removeClass("active");
    if(siteSection[0] !== "articles")
        $("#"+siteSection[0]).addClass("active");
    window.scrollTo(0,0);
}


$(document).ready(function() {

    if(page.length > 1){
        loadPage(page);
        updatePage(page);
    }
    else if(article.length > 1)
    {
        buildArticle(article, function () {
            $(".loaded").removeClass("loaded");
            $("#mainPageContainer").html(preloadPageData);
            updatePage(getArticleBookmarkPath(article));
        });
    }
    else
        loadPage("home");

    window.onpopstate = function (event) {
        if(event.state)
        {
            console.log("PopState: " + window.location.pathname);
            loadPageOnBack(window.location.pathname);
        }
    };



    $(".navlink").click(function(){
        var page = $(this).children()[0].innerHTML.toLowerCase();
        if($(this).hasClass("loaded"))
        {
            $("#mainPageContainer").html(preloadPageData);
        }
        else{
            loadPage(page);
        }
        if(page == "home")
            page = "/";
        console.log(page);
        //history.pushState('data', '', page);
        updatePage(page);
    });

    $(".navlink").hover(function () {
        if($(this).hasClass("loaded")){

        }else {
            $(this).addClass("lock");
            preloadPage($(this));
        }
    }, function () {

    });

    $(document).on("mouseover", ".article-preload", null, function () {

        var element = $(this);
        var name = element.attr("preload");
        console.log("Mouseover: \"" + name + "\"");
        if($(this).hasClass("loaded"))
        {
            console.log("Element already loaded");
        }else{
            console.log("Element not loaded");
            buildArticle(name, function () {
                $(".loaded").removeClass("loaded");
                element.addClass("loaded");
                console.log(element.html());
            });
        }

    });
    $(document).on("click", ".article-preload", null, function () {
        var link = $(this).attr("preload");
        if($(this).hasClass("loaded"))
        {
            $("#mainPageContainer").html(preloadPageData);
            updatePage(getArticleBookmarkPath(link));
            console.log("Preload");
        }else {

            buildArticle(link, function () {
                $(".loaded").removeClass("loaded");
                $("#mainPageContainer").html(preloadPageData);
                updatePage(getArticleBookmarkPath(link));
            });
            console.log("No load");
        }

    });
});

