<div id="featured-article">
<?php
    include "/var/www/sites/isogen/assets/php/iso-includes/featured-article.php";
    ?>
</div>
<div class="container">
    <div id="card-div" class="container-fluid" style="max-width: 800px;">

            <?  include "/var/www/sites/isogen/assets/php/CardBuilder.php";
                GenerateCardsByKey();
            ?>


    </div>

</div>

