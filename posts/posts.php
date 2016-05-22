<div class="container">
    <div class="jumbotron" style="">
        <h1>Posts and Articles</h1>
    </div>
    <div id="card-div" class="container-fluid" style="max-width: 800px;">

            <?php
            $path = "/var/www/sites/isogen/posts/articles";
            $directories = glob( $path. '/*' , GLOB_ONLYDIR);
            $num_articles = count($directories);
            $column;


            for ($i = 0; $i<$num_articles; $i++){
                $_POST["name"] = basename($directories[$i]);
                ob_start();
                include("/var/www/sites/isogen/assets/php/CardBuilder.php");
                $column[$i%3] .= ob_get_clean();
            }
            for ($i = 0; $i<count($column); $i++){
                ?>
                <div class="col-lg-6">
                    <?=$column[$i]?>
                </div>

                <?php
            }

            ?>


    </div>

</div>