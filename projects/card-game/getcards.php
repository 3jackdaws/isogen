<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 6/25/2016
 * Time: 9:24 PM
 */
function createCards(){
    $card_path = realpath($_SERVER["DOCUMENT_ROOT"]) . "/projects/card-game/cards/";
    $cards = glob($card_path . "*.json");
    foreach($cards as $cardfile){
        $json = fopen($cardfile, "r");
        $jsontext = fread($json, filesize($cardfile));
        $card_info = json_decode($jsontext);

        ?>

        <div class="cg-card noselect">

                <h1><?=$card_info->name?></h1>
                <div class="cg-img" style="background-image: url('<?=$card_info->pic?>')"></div>
                <div class="cg-desc"><?=$card_info->desc?></div>
                
                <div class="cg-stats">ATK: <?=$card_info->atk?> | DEF: <?=$card_info->def?></div>


        </div>

        <?php
    }
}

createCards();