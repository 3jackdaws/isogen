<?php
$start = microtime(true);
$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/Page.php');
$page = new CustomPage();
$page->writeHead();

$page->writeNavbar();





?>

<div id="carddiv" class="container" style="margin-top: 50px">



</div>
<button class="btn btn-primary add-a-card" onclick="addCard()">Add a Card <span style="font-height: 12px" class="glyphicon glyphicon-plus-sign"></span></button>
<div id="addcard" class="add-card-modal" style="visibility: hidden">
    <h2>Add a new Card</h2>
    <hr>
    <form name="acForm" enctype="multipart/form-data" method="post">
        <input class="form-control" name="name" placeholder="Name">
        <br>
        <input class="form-control" name="atk" placeholder="Attack Power">
        <br>
        <input class="form-control" name="def" placeholder="Defense Rating">
        <br>
        <input class="form-control" name="desc" placeholder="Description">
        <br>
        <label class="btn btn-default btn-file" style="float: left;">
            Browse <input name="pic" type="file" style="display: none;" onchange="javascript:document.getElementById('upload-file-info').innerHTML = this.value.split(/[\\/]/).pop()">
        </label>
        <span class='label well-sm' style="color: black; float: left; font-size: 12px" id="upload-file-info"></span>
        <span id="error"></span>
        <button type="button" class="btn btn-primary" style="float: right" onclick="submitNewCard()">Add Card</button>
    </form>
</div>
<div id="change" style="position: absolute; bottom: 20px; right: 20px; width: 200px; height: 300px; background-color: #BBB; text-align: center; vertical-align: middle; line-height: 150px">
    <h1>Place Card to Change</h1>
</div>
<script>
    InstantClick.on('change', function(){
        getCards();
        document.getElementById("change").addEventListener("mouseup", function (e) {
            alert(e);
        });


    });
    var mouseX;
    var mouseY;
    var track;
    var currentCard;
    var currentZIndex = 2;
    function pickUpCard(event){
        var card = event.currentTarget;
        if(card === currentCard){
            putDownCard();

            return;
        }
        currentCard = card;
        card.style.zIndex = currentZIndex++;
        if(event.button != 0) return;
        var offsetX;
        var offsetY;
        var cardBoundaries = card.getBoundingClientRect();
        offsetX = cardBoundaries.left - mouseX - 20;
        offsetY = cardBoundaries.top - mouseY - 20;

        card.style.position = "absolute";
        track = window.setInterval(function () {
            card.style.left = mouseX + offsetX;
            card.style.top = mouseY + offsetY;
        }, 15);
    }
    function putDownCard(){
        clearInterval(track);
        currentCard = null;
    }

    function addCard(){
        var modal = document.getElementById("addcard");
        if(modal.style.visibility == "hidden"){
            modal.style.zIndex = 100;
            modal.style.visibility = "visible";
        } else{
            modal.style.zIndex = -100;
            modal.style.visibility = "hidden";
        }

    }

    function submitNewCard(){
        var fdata = new FormData(document.forms.namedItem("acForm"));
        var name = document.getElementsByName("name")[0].value;
        var atk = document.getElementsByName("atk")[0].value;
        var def = document.getElementsByName("def")[0].value;
        var desc = document.getElementsByName("desc")[0].value;
        var pic = document.getElementsByName("pic")[0].value;
        var errorDiv = document.getElementById("error");
        fdata.append("name", name);
        fdata.append("atk", atk);
        fdata.append("def", def);
        fdata.append("desc", desc);
        $.post("/projects/card-game/addcard.php", fdata, function(data){
            console.log(data);
            var response = JSON.parse(data);
            errorDiv.innerHTML = response.message;
            getCards();
        })
    }

    function cardMenu(event) {
        console.log("Menu");
        console.log(event);
    }

    function profileCards(){
        var cards = document.getElementsByClassName("cg-card");
        for(var i = cards.length-1; i>=0; i--){
            cards[i].addEventListener("mousedown", pickUpCard);
            cards[i].addEventListener("mouseup", putDownCard);
            cards[i].addEventListener("contexmenu", cardMenu);
            var rect = cards[i].getBoundingClientRect();

            cards[i].style.left = rect.left;
            cards[i].style.top = rect.top;
            cards[i].style.position = "absolute";
        }
    }

    function getCards(){
        $.get("/projects/card-game/getcards.php", function (data) {
            document.getElementById("carddiv").innerHTML = data;
            profileCards();
        });
    }

    document.onmousemove = function (event) {
//        mouseX = event.clientX;
//        mouseY = event.clientY;
        mouseX = event.screenX;
        mouseY = event.screenY;
//        console.log(event.pageX);
//        console.log(event.screenX);
    }




    document.onmouseup = function(){putDownCard()};


</script>
<?php
$page->writeFooter();