
<html>
<script src="/assets/js/iso-preloading.js"></script>
<script>
    iso.get("/assets/comp/main.html", function(data){
                document.write(data);
                iso.get("/assets/php/ArticleBuilder.php?name=<?=basename(__DIR__)?>", function(data){
                document.getElementById("main").innerHTML = data;
            	});
            });
</script>
    





