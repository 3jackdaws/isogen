/**
 * Created by ian on 5/20/16.
 */
var preloadPageData;

function loadPage(page) {
    var path = getURL(page);
    $.get(path, function (data) {
        $("#mainPageContainer").html(data);
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
            element.removeClass("lock");
            element.addClass("loaded");
        });
    }
}

function getURL(file){
    return '/' + file + '/' + file + ".php";
}

function getArticlePath(article) {
    return "/posts/articles/" + article + "/" + article + ".html";
}

function getArticleBookmarkPath(article) {
    return "/posts/articles/" + article;
}

function buildArticle(name, onPreloadEvent){
    var link = getArticlePath(name);
    $.post("/assets/php/ArticleBuilder.php", { link: link}, function (data) {
        preloadPageData = data;
        onPreloadEvent();
    });
}

$(document).ready(function() {

    if(page.length > 1){
        loadPage(page);
        history.pushState('data', '', page);
    }
    else if(article.length > 1)
    {
        buildArticle(article, function () {
            $(".loaded").removeClass("loaded");
            $("#mainPageContainer").html(preloadPageData);
            history.pushState('data', null, getArticleBookmarkPath(article));
        });
    }
    else
        loadPage("home");

    // window.onpopstate(function () {
    //
    // });

    $(".navlink").click(function(){
        $(".active").removeClass("active");
        $(this).addClass("active");
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
        history.pushState('data', '', page);
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
            history.pushState('data', null, getArticleBookmarkPath(link) );
            console.log("Preload");
        }else {

            buildArticle(link, function () {
                $(".loaded").removeClass("loaded");
                $("#mainPageContainer").html(preloadPageData);
                history.pushState('data', null, getArticleBookmarkPath(link));
            });
            console.log("No load");
        }

    });
});

