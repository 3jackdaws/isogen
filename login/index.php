<?php
//if($_SERVER["HTTPS"] != "on")
//{
//    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//    exit();
//}
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/PagePrimitives.php');
PagePrimitives::std_page();
    ?>
    <div class="container">
        <div class="jumbotron" style="margin-top: 60px; position: relative;">
            <div style="position: absolute; right: 10px; top: 10px"><a href="register.php">Register instead</a></div>
            <center>
            <h1>LOGIN</h1>
            <form method="POST" style="max-width: 300px;" name="login">
                <input class="form-control input-lg" name="user" placeholder="Username" style="text-align: center; margin: 6px;"/>
                <input class="form-control input-lg" name="password" type="password" placeholder="Password" style="text-align: center; margin: 6px;"/>
                <button id="sub" class="btn btn-primary" type="button" onclick="onClickSubmit()">Log In</button>
                <br>

                    <label class="label control-label" style="color: black;">Keep me logged in</label>
                    <input class="checkbox-inline" type="checkbox" name="cookie"/>
            </form>
        </div>
    </div>
</body>
    <script>
        var globalSubmitLock = false;
        function onClickSubmit() {
            if(globalSubmitLock) return;
            globalSubmitLock = true;
            var button = document.getElementById("sub");
            button.innerHTML = "<span class='glyphicon glyphicon-refresh spin'></span>"
            var fdata= new FormData(document.forms.namedItem("login"));
            if(fdata.get("password").length < 6){
                error("Password is less than 6 characters");
                globalSubmitLock = false;
                button.innerHTML = "Log In";
                return;
            }

            $.post("login.php", fdata, function (data) {
                var response = JSON.parse(data);
                console.log(response);
                if(fdata.get("cookie") === "on"){
                    $.setCookie('token', response.cookie, 1);
                }else{
                    $.setCookie('token', response.cookie, null);
                }
                globalSubmitLock = false;
                button.innerHTML = "Log In";
                if(response.error == 0){
                    window.location = "/account/";
                }
                else{
                    alert(response.message);
                }

            });

        }
            
        function error(err){
            alert(err);
        }


    </script>
