<?php
/*
    杨辉三角
*/
function yhsj($s){
    $n = [1];
    for($i = 0; $i < $s; $i++){
        $m = $n;
        for ($j = 0; $j <= $i; $j++){
            echo $n[$j] = (isset($m[$j]) ? $m[$j] : 0) + (isset($m[$j - 1]) ? $m[$j - 1] : 0);
            if($j < $i)
                echo ',';
        }
        echo '<br>';
    }
}


yhsj(10);