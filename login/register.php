<?php
//if($_SERVER["HTTPS"] != "on")
//{
//    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//    exit();
//}
if(isset($_POST["user"])){
    require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/AuthModule.php");
    $v = $_POST;
    if(isset($v["password"]) && isset($v["name"])){
        $authmod = new AuthModule();
        echo $authmod->addUser($v["name"], $v["user"], $v["password"]);
    }
    else{
        $r = [];
        $r["error"] = 1;
        $r["message"] = "Missing required parameters";
        echo json_encode($r);
    }
    exit();
}

$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/PagePrimitives.php');
PagePrimitives::std_page();
?>
<div class="container">
    <div class="jumbotron" style="margin-top: 60px; position: relative;">
        <div style="position: absolute; right: 10px; top: 10px"><a href="index.php">Login instead</a></div>
        <center>
            <h1>REGISTER</h1>
            <form method="POST" style="max-width: 300px;" name="login">
                <input class="form-control input-lg" name="name" placeholder="Full Name (Appears in articles)" style="text-align: center; margin: 6px;"/>
                <input class="form-control input-lg" name="user" placeholder="Email" style="text-align: center; margin: 6px;"/>
                <input class="form-control input-lg" name="password" type="password" placeholder="Password" style="text-align: center; margin: 6px;"/>
                <input class="form-control input-lg" name="pconf" type="password" placeholder="Confirm Password" style="text-align: center; margin: 6px;"/>
                <button id="sub" class="btn btn-primary" type="button" onclick="onClickSubmit()">Log In</button>
                <br>

                <label class="label control-label" style="color: black;">Keep me logged in</label>
                <input class="checkbox-inline" type="checkbox" name="cookie"/>
            </form>
    </div>
</div>

<script>
    var globalSubmitLock = false;
    function onClickSubmit() {
        if(globalSubmitLock) return;
        globalSubmitLock = true;
        var button = document.getElementById("sub");
        button.innerHTML = "<span class='glyphicon glyphicon-refresh spin'></span>"
        var fdata= new FormData(document.forms.namedItem("login"));
//        if(fdata.get("password").length < 6){
//            error("Password is less than 6 characters");
//            globalSubmitLock = false;
//            button.innerHTML = "Log In";
//            return;
//        }

        $.post("register.php", fdata, function (data) {
            var response = JSON.parse(data);
            if(fdata.get("cookie") === "on"){
                $.setCookie('token', response.cookie, 1);
            }else{
                $.setCookie('token', response.cookie, null);
            }
            globalSubmitLock = false;
            button.innerHTML = "Log In";
//            if(response.success == 1){
//
//            }
            //window.location = "/";
        });

    }

    function error(err){
        alert(err);
    }


</script>
