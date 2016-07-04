<head>
    <style>
        table{
            margin: 0 auto;

        }
        td{
            border: 1px solid lightgrey;
            width: 30px;
            height: 35px;
            text-align: center;
            vertical-align: middle;
            border-spacing: 0;
        }
        td:hover{
            background-color: rgba(0,0,0,0.1);
        }
        .separator{
            border: 1px solid black;
        }
        .userdefined{
            background-color: #EEFFFF;
        }

        .sa{
            background-color: #2aabd2;
        }

        .sb{
            /*background-color: #2b542c;*/
        }
    </style>
    <script>
        var activeCell;
        document.addEventListener("keydown", writeKey);
        window.addEventListener("load", function (event) {
            console.log("fire");
            var tds = document.getElementsByTagName("td");
            for(var i = 0; i<tds.length; i++){
                if(tds[i].innerHTML == "&nbsp;"){
                    tds[i].addEventListener("mouseover", activateCell);
                    tds[i].className += " userdefined";
                }
                else{
                    tds[i].addEventListener("mouseover", function () {
                        activeCell = null;
                    });

                }

            }
        });
        function activateCell(event){
            activeCell = event.target;
            if(activeCell.attributes.getNamedItem("fixed") == true)
                activeCell = null;
        };

        function writeKey(event){
//            console.log(event.keyCode);
            if(activeCell != null ){
                if(event.keyCode > 47 && event.keyCode < 59){
                    activeCell.innerHTML= String.fromCharCode(event.keyCode);
                }
                else if(event.keyCode == 32){
                    activeCell.innerHTML = " ";
                }
            }

        }
    </script>
</head>
<body>
<div style="margin: 0 auto">
<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 6/30/16
 * Time: 9:51 AM
 */

require(realpath($_SERVER["DOCUMENT_ROOT"]) . "/assets/php/SudokuGen.php");

echo webWrapSudokuString(3);

?>
</div>
</body>