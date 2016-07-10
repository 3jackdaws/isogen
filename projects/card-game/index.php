<?php

$basepath = realpath($_SERVER['DOCUMENT_ROOT']);
include_once($basepath . '/assets/php/PagePrimitives.php');
PagePrimitives::std_head("Card Game", array("/projects/card-game/card-game.css"));
PagePrimitives::std_navbar(PagePrimitives::named_login());

?>

<div id="carddiv" class="container" style="margin-top: 50px">



</div>
<button class="btn btn-primary add-a-card" onclick="toggleAddCardModal()">Add a Card <span style="font-height: 12px" class="glyphicon glyphicon-plus-sign"></span></button>
<div id="addcard" class="add-card-modal" style="visibility: hidden; ">
    <a style="position: absolute; top: 10px; right: 10px; color: grey" href="javascript:toggleAddCardModal();" ><span class="glyphicon glyphicon-remove"></span></a>
    <h2>Add a new Card</h2>
    <hr>
    <form name="acForm" enctype="multipart/form-data" method="post">
        <input class="form-control" name="name" maxlength="15" placeholder="Name">
        <br>
        <input class="form-control" name="atk" maxlength="3" placeholder="Attack Power">
        <br>
        <input class="form-control" name="def" maxlength="3" placeholder="Defense Rating">
        <br>
        <input class="form-control" name="desc" maxlength="140" placeholder="Description">
        <br>
        <label class="btn btn-default btn-file" style="float: left;">
            Select Image <input name="pic" type="file" style="display: none;" onchange="javascript:document.getElementById('upload-file-info').innerHTML = this.value.split(/[\\/]/).pop()">
        </label>
        <span class='label well-sm' style="color: black; float: left; font-size: 12px" id="upload-file-info"></span>
        <span id="error"></span>
        <button type="button" class="btn btn-primary" style="float: right" onclick="submitNewCard()">Add Card</button>
    </form>
</div>
<div id="del" class="noselect delete-slot grey-pattern" onclick="toggleExpand(this)">
    <span class='glyphicon glyphicon-remove'></span>
</div>
</body>
<script src="card-game.js">

</script>

