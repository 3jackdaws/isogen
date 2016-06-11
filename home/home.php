<div id="featured-article">
<?php
    include "/var/www/sites/isogen/assets/php/iso-includes/featured-article.php";
    ?>
</div>

    <div id="card-div" class="container-fluid" style="max-width: 900px; padding: 0;">

            <?php  include "/var/www/sites/isogen/assets/php/CardBuilder.php";
                GenerateCardsByKey();
            ?>


    </div>



