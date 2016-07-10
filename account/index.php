<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/26/2016
 * Time: 11:46 AM
 */
if(!isset($_COOKIE["token"]) || strlen($_COOKIE['token']) < 10 ){
    header( 'Location: /login' ) ;
    exit();
}
$basedir = realpath($_SERVER["DOCUMENT_ROOT"]);
require($basedir . "/assets/php/AuthModule.php");
require($basedir . "/assets/php/PagePrimitives.php");
require($basedir . "/assets/php/DBArticle.php");
$authmod = new AuthModule();
$user = json_decode($authmod->loginFromToken($_COOKIE['token']));

PagePrimitives::std_head("Account");

PagePrimitives::std_navbar("<a class=\"btn btn-primary\" onclick=\"javascript:$.setCookie('token', null, null);window.location='/'\">Log Out</a>");
    ?>
<iframe id="pframe" class="" src="/account/temp" frameborder="0" style="z-index: 100; width: 0%; height: 0%; position: fixed; top: 0; left: 0;" ></iframe>
<div style="position: relative; margin-top: 50px; " class="container">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation" class="active"><a href="#t1" data-toggle="tab">Home</a></li>
            <li role="presentation"><a href="#t2" data-toggle="tab">Profile</a></li>
            <li role="presentation"><a href="#">Messages</a></li>
        </ul>
        
        <div class="col-lg-4" style="border: 1px solid lightgray; border-radius: 4px; margin-top: 50px; text-align: center;">
            <h1>Upload New Article</h1>
            <form method="post" id="newarticle">
                <label class="btn btn-default btn-file" style="margin: 0px 10px 10px 20px;">
                    Upload Markup File and Images<br><input id="files" name="files[]" multiple type="file" style="display: none;" onchange="AUF.updateFiles()">
                </label>
                <div class='list-group' id="fld">

                </div>
                <div class='list-group' id="issues">

                </div>
                <div class='btn-group btn-group-justified'>
                    <a id="parsebutton" class='btn btn-primary disabled' onclick='AUF.uploadComponents()' >Parse Markup</a>
                    <a id="publishbutton" class='btn btn-success disabled' onclick='AUF.publish()' >Publish Article</a>
                </div>
            </form>

            <div class="well-lg">Press <span class="btn btn-sm btn-default disabled">S</span> to preview article.</div>
        </div>
        <div id="prevArt" class="col-lg-8" style="margin-top: 50px; text-align: center">
            <h1>Articles by you</h1>
            <h6>Highlighted article is featured.  Click to feature a different article.</h6>
            <div class="list-group">
            <?php
            $dbcon = new DBArticle();
            $articles = $dbcon->getArticlesByAuthor($user->name);

            foreach ($articles as $article){
                $class = "list-group-item";
                if($article['featured'] == 1)
                    $class .= " list-group-item-info";

                ?>

                <a onclick="AUF.markFeatured(this, <?=$article['article_id']?>)" class="<?=$class?>">
                    <h4><?=$article['heading']?></h4>
                    <h5><?=$article['subheading']?></h5>
                </a>

                <?php
            }

            ?>
            </div>

        </div>
    </div>
</body>
<script>
    var token = "<?=$_COOKIE['token']?>";
    var AUF = {
        fileListDiv:    {},
        parseButton:    {},
        publishButton:  {},
        issueDiv:       {},
        canParse: false,
        canPublish: false,
        init:function(){
            this.fileListDiv = document.getElementById('fld');
            this.parseButton = document.getElementById('parsebutton');
            this.publishButton = document.getElementById('publishbutton');
            this.issueDiv = document.getElementById('issues');
            document.addEventListener("keydown", AUF.showPreview);
            document.addEventListener("keyup", AUF.unshowPreview);
        },
        updateFiles: function(){
            this.canParse = this.canPublish = false;
            this.issueDiv.innerHTML = "";
            this.fileListDiv.innerHTML = "";
            var filesItem = document.getElementById('files');
            var hasMarkupFile = false;
            for(var i = filesItem.files.length-1; i>=0; i--){
                this.fileListDiv.innerHTML += "<a class='list-group-item'>" + filesItem.files[i].name + "</a>";
                if(filesItem.files[i].name.match(/.html$/)) hasMarkupFile = true;
            }
            if(!hasMarkupFile){
                this.issueDiv.innerHTML += "<a class='list-group-item list-group-item-danger'>Missing or misnamed markup file</a>";
                return;
            }
            if(filesItem.files.length < 2){
                this.issueDiv.innerHTML += "<a class='list-group-item list-group-item-danger'>Missing or misnamed image file</a>";
                return;
            }
            this.canParse = true;
            this.updateButtonStatus();
        },
        updateButtonStatus: function(){
            this.parseButton.className = this.parseButton.className.replace("disabled", "");
            if(this.canParse == false) this.parseButton.className += " disabled";

            this.publishButton.className = this.publishButton.className.replace("disabled", "");
            if(this.canPublish == false) this.publishButton.className += " disabled";
        },
        uploadComponents: function(){
            var fdata = new FormData(document.forms.namedItem("newarticle"));
            $.post("/account/parse.php", fdata, this.getServerResponse);
        },
        getServerResponse: function(data){
            AUF.issueDiv.innerHTML = "";
            console.log(data);
            var response = JSON.parse(data);
            if(response.error == 1){
                var num_errros = response.message.length;
                for(var i = 0; i<num_errros; i++){
                    AUF.issueDiv.innerHTML += "<a class='list-group-item list-group-item-danger'>" + response.message[i] + "</a>";
                }
            }

            if(response.error == 0){
                document.getElementById('pframe').contentWindow.location = document.getElementById('pframe').contentWindow.location;
                AUF.issueDiv.innerHTML += "<a class='list-group-item list-group-item-success'>Article parsed successfully</a>";
                AUF.issueDiv.innerHTML += "<a class='list-group-item'>" + "Article will publish to:<br>" + response.extra + "</a>";
                AUF.canPublish = true;
                AUF.updateButtonStatus();
            }

        },
        publish: function(){
            var fdata = new FormData(document.forms.namedItem("newarticle"));
            $.post("/account/publish.php", fdata, this.getServerResponse);
        },
        showPreview: function (event){
            if(event.keyCode == 83){
                console.log('s');
                document.getElementById("pframe").style.width = '100%';
                document.getElementById("pframe").style.height = '100%';
            }
            else{
                console.log(event.keyCode);
            }
        },
        unshowPreview: function(event){
            document.getElementById("pframe").style.width = 0;
            document.getElementById("pframe").style.height = 0;
        },
        markFeatured: function (e, id) {
            var undo = document.getElementById("prevArt").getElementsByClassName("list-group-item-info");
            if(undo.length > 0)
                undo[0].className = undo[0].className.replace(/list-group-item-info/, "");
            e.className += " list-group-item-info";
            console.log(e);
            $.post2("/assets/ajax/feature.php", "token=" + token +"&id="+id, function (data) {
                console.log(data);
            })
        }

    };
    AUF.init();
</script>
</html>

