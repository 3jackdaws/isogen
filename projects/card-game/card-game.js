/**
 * Created by ian on 7/4/16.
 */


var mouseX;
var mouseY;
var track;
var deleteIntervals = {};

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
    var cardBoundaries = card.getBoundingClientRect();
    var offsetX = cardBoundaries.left - mouseX - 16;
    var offsetY = cardBoundaries.top - mouseY - 14;
    card.style.position = "absolute";
    track = window.setInterval(function () {
        card.style.left = mouseX + offsetX;
        card.style.top = mouseY + offsetY;
    }, 15);
}
function putDownCard(){
    clearInterval(track);
    checkDelete(currentCard);
    currentCard = null;
}
function toggleAddCardModal(){
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
//            cards[i].addEventListener("mouseup", putDownCard);
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

function checkDelete(card){
    if(!card) return;
    var deleteRect = document.getElementById("del").getBoundingClientRect();
    var cardRect = card.getBoundingClientRect();
    var cardname = card.getElementsByTagName("h1")[0].innerHTML;
    if(cardRect.left > deleteRect.left && cardRect.top > deleteRect.top){
        card.className += " shrink";

        var stid = window.setTimeout(function(){
            card.remove();
            var params = "card=" + encodeURI(cardname);
            $.get("delcard.php"+"?"+params, function(d){console.log(d)});
        }, 8000);
        deleteIntervals[cardname] = stid;
    }
    else{
        card.className = card.className.replace("shrink", "");
        if(cardname in deleteIntervals)
            clearInterval(deleteIntervals[cardname]);
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
