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

require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/AuthModule.php");
require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/PagePrimitives.php");
$authmod = new AuthModule();
$user = json_decode($authmod->loginFromToken($_COOKIE['token']));

?>
<html>
<head>
    <?PagePrimitives::std_head()?>
    <style>
        body{
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?PagePrimitives::std_navbar("<a class=\"btn btn-primary\" onclick=\"javascript:$.setCookie('token', null, null);window.location='/'\">Log Out</a>")?>

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
                    Upload Markup File and Images<br><input id="files" name="files[]" multiple type="file" style="display: none;" onchange="ArticleUploadForm.updateFiles()">
                </label>
                <div class='list-group' id="fld">

                </div>
                <div class='list-group' id="issues">

                </div>
                <div class='btn-group btn-group-justified'>
                    <a id="parsebutton" class='btn btn-primary disabled' onclick='ArticleUploadForm.uploadComponents()' >Parse Markup</a>
                    <a id="publishbutton" class='btn btn-success disabled' onclick='ArticleUploadForm.publish()' >Publish Article</a>
                </div>
                
            </form>
        </div>
        <div class="col-lg-8" style="margin-top: 50px;">
            <div style="height: 100%; padding-left: 30px">
                <iframe id="pframe" class="zoom-frame" src="./temp" frameborder="0" ></iframe>

            </div>
        </div>
    </div>
</body>
<script>
    var ArticleUploadForm = {
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
            $.post("./parse.php", fdata, this.getServerResponse);
        },
        getServerResponse: function(data){
            ArticleUploadForm.issueDiv.innerHTML = "";
            console.log(data);
            var response = JSON.parse(data);
            if(response.error == 1){
                var num_errros = response.errorlines.length;
                for(var i = 0; i<num_errros; i++){
                    ArticleUploadForm.issueDiv.innerHTML += "<a class='list-group-item list-group-item-danger'>" + response.errorlines[i] + "</a>";
                }
            }

            if(response.error == 0){
                document.getElementById('pframe').contentWindow.location = document.getElementById('pframe').contentWindow.location;
                ArticleUploadForm.issueDiv.innerHTML += "<a class='list-group-item list-group-item-success'>Article parsed successfully</a>";
                ArticleUploadForm.issueDiv.innerHTML += "<a class='list-group-item'>" + response.publishdir + "</a>";
                ArticleUploadForm.canPublish = true;
                ArticleUploadForm.updateButtonStatus();
            }

        },
        publish: function(){
            var fdata = new FormData(document.forms.namedItem("newarticle"));
            $.post("./publish.php", fdata, this.getServerResponse);
        }

    };
    ArticleUploadForm.init();
</script>
</html>

