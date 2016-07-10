/**
 * Created by ian on 7/4/16.
 */


var mouseX;
var mouseY;
var track;
var deleteIntervals = {};
var num_deleting = 0;
var currentCard;
var currentZIndex = 2;

function pickUpCard(event){
    if(event.button != 0) return;
    var card = event.currentTarget;
    if(card === currentCard){
        putDownCard();
    }
    else{
        currentCard = card;
        card.style.zIndex = currentZIndex++;

        var cardBoundaries = card.getBoundingClientRect();
        var offsetX = cardBoundaries.left - mouseX - 20;
        var offsetY = cardBoundaries.top - mouseY - 20;
        card.style.position = "absolute";
        track = window.setInterval(function () {
            card.style.left = mouseX + offsetX;
            card.style.top = mouseY + offsetY;
        }, 15);
    }
}

function putDownCard(){
    clearInterval(track);
    currentCard = null;
}
function toggleAddCardModal(){
    var modal = document.getElementById("addcard");
    if(modal.style.visibility == "hidden"){
        modal.style.zIndex = 100;
        modal.style.visibility = "visible";
        modal.className += " grow";
    } else{
        modal.style.zIndex = -100;
        modal.style.visibility = "hidden";
        modal.className = modal.className.replace("grow", "");
    }

}
function submitNewCard(){
    var fdata = new FormData(document.forms.namedItem("acForm"));
    var errorDiv = document.getElementById("error");
    $.post("/projects/card-game/addcard.php", fdata, function(data){
        console.log(data);
        var response = JSON.parse(data);
        errorDiv.innerHTML = response.message[0];
        if(response.error == false){
            document.getElementsByName("acForm")[0].reset();
            toggleAddCardModal();
            getCards();
        }
    })
}

function profileCards(){
    var cards = document.getElementsByClassName("cg-card");
    for(var i = cards.length-1; i>=0; i--){
        cards[i].addEventListener("mousedown", pickUpCard);
        cards[i].addEventListener("mouseover", clearDelete);
        cards[i].addEventListener("mouseout", checkDelete);
        var rect = cards[i].getBoundingClientRect();
        cards[i].style.left = rect.left;
        cards[i].style.top = rect.top;
        cards[i].style.position = "absolute";
        cards[i].className += " grow";
    }
}
function getCards(){
    $.get("/projects/card-game/getcards.php", function (data) {
        document.getElementById("carddiv").innerHTML = data;
        profileCards();
    });
}

function clearDelete(event){
    var card = event.currentTarget;
    var cardname = card.getElementsByTagName("h1")[0].innerHTML;
    if(cardname in deleteIntervals){
        clearInterval(deleteIntervals[cardname]);
        card.className = card.className.replace(" shrink", "");
        if(num_deleting > 0)
            num_deleting--;
        changeDelBG();
    }
}

function checkDelete(event){
    var card = event.currentTarget;
    if(!card) return;
    var deleteRect = document.getElementById("del").getBoundingClientRect();
    var cardRect = card.getBoundingClientRect();
    var cardname = card.getElementsByTagName("h1")[0].innerHTML;

    if(cardRect.left > deleteRect.left && cardRect.top > deleteRect.top){
        card.className = card.className.replace(/ grow/, "");
        card.className += " shrink";
        num_deleting++;
        changeDelBG();
        var stid = window.setTimeout(function(){
            card.style.visibility = "hidden";
            card.remove();
            var params = "card=" + encodeURI(cardname);
            num_deleting--;
            $.get("delcard.php"+"?"+params, function(d){console.log(d)});
        }, 8000);
        deleteIntervals[cardname] = stid;
    }
    else{
        card.className = card.className.replace(" shrink", "");
        if(cardname in deleteIntervals){
            clearInterval(deleteIntervals[cardname]);
            if(num_deleting > 0)
                num_deleting--;
        }

    }
    changeDelBG();
}

function changeDelBG(){
    if(num_deleting > 0){
        document.getElementById("del").className = document.getElementById("del").className.replace(" grey-pattern", " black-bg");
    }else{
        document.getElementById("del").className = document.getElementById("del").className.replace(" black-bg"," grey-pattern");
    }
}

function toggleExpand(e){
    if(e.className.match(/ expand-delete/)){
        e.className = e.className.replace(" expand-delete", "");
        e.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
    }else{
        e.innerHTML = "";
        e.className += " expand-delete";
        window.setTimeout(function () {
            e.innerHTML = "Place card to delete";
        }, 200);
    }
}



InstantClick.on('change', function(){
    getCards();
});
window.addEventListener("load", function(){
    InstantClick.init();
//        getCards();
});

document.onmousemove = function (event) {
    mouseX = event.screenX;
    mouseY = event.screenY;
}
document.onmouseup = function(){putDownCard()};
