

<?php
#SudokuGenerator

function genSudoku($n){
    $sudokuString = [];
    $sudokuString["n"] = $n;
    for ($i = 0; $i <$n *$n; $i++)
            for ($j = 0; $j <$n *$n; $j++)
                $sudokuString[$i][$j] = ($i *$n + $i /$n + $j) % ($n*$n) + 1;
    return $sudokuString;
}

function scrambleX($sstring){
    $n = $sstring["n"];
    for ($i = 0; $i<$n*$n;$i++){
        $swap_num = rand(0,$n*$n-1);
        $hold = $sstring[$swap_num];
        $sstring[$swap_num] = $sstring[$i];
        $sstring[$i] = $hold;
    }
    return $sstring;
}

function scrambleY($sstring){
    $n = $sstring["n"];
    for ($j = 0; $j<$n*$n;$j++){
        $swap_num = rand(0,$n*$n-1);
        for ($i = 0; $i<$n*$n; $i++){
            $hold = $sstring[$i][$swap_num];
            $sstring[$i][$swap_num] = $sstring[$i][$j];
            $sstring[$i][$j] = $hold;
        }
    }
    return $sstring;
}


function removeCells($sstring, $percent){
    $n = $sstring["n"];
    for ($i = 0; $i<$n*$n;$i++){
        for ($j = 0; $j<$n*$n;$j++){
            if(rand(0, 100) < $percent){
                $sstring[$i][$j] = "&nbsp;";
            }
        }
    }
    return $sstring;
}

function checkX($s){
    $n = $s["n"];
    $true_val = 0;
    for ($i = 0; $i<$n*$n;$i++){
        $true_val +=$i;
    }
    for ($i = 0; $i<$n*$n;$i++){
        $check_val = 0;
        for ($j = 0; $j<$n*$n;$j++){
            $check_val+=$s[$i][$j];
            echo $s[$i][$j] . " ";
        }
        if($check_val != $true_val){
            echo $check_val . " " . $true_val;
            return false;
        }
        echo "<br>";
    }
    return true;
}

function webWrapSudokuString($n){

    $sstring = genSudoku($n);
    $sstring = scrambleX($sstring);
    $sstring = scrambleY($sstring);
    $sstring = removeCells($sstring, 60);
    $toggle = "sa";
    echo "<table>";
    for ($i = 0; $i<$n*$n; $i++){
        if($i%($n*$n)==0) $toggle == "sa" ? $toggle = "sb" : $toggle = "sa";
        elseif($i%$n==0) echo "<tr>";
        for ($j = 0; $j<$n*$n; $j++){
            echo "<td class='" . $toggle . "'>" . $sstring[$i][$j] . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}