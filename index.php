

    <script src="/assets/js/iso-preloading.js"></script>
    <script>
    iso.get("/assets/comp/main.html", function(data){
                document.write(data);
                iso.get("/home/home.php", function(text){
                    document.getElementById("main").innerHTML = text;
                });
            });
    
        function collapse(){
            var navbar = document.getElementById("navbar");
            var regex = new RegExp(" collapse");
            if(navbar.className.match(regex))
                navbar.className = navbar.className.replace(regex, "");
            else
                navbar.className += " collapse";
        }
    
    </script>
</body>