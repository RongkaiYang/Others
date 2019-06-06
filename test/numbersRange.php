<?php
// +----------------------------------------------------------------------
// | m个数取n个，每一位不重复组合
// +----------------------------------------------------------------------
// | Author: Rongkai Yang <yangrk2008@qq.com>
// +----------------------------------------------------------------------
$set = range(1, 11);
$timeStart = microtime(true);
print_r(getSetDiffNumber($set, 5));
$timeEnd = microtime(true);
echo '运行时间：'.($timeEnd - $timeStart);

function getSetDiffNumber($set, $num){
    $set = array_values(array_unique($set));
    if($num <= 1){
        return $set;
    }
    if($num > count($set)){
        return 'error:$num值大于$set元素';
    }

    $numSet = count($set) - 1;
    for ($i = 0; $i < $num; $i++) { 
        $setpSet[$i] = 0;
    }
    while (true) {
        for ($i = ($num - 1); $i >= 0 ; $i--) { 
            if($setpSet[$i] > $numSet){
                $setpSet[$i] = 0;
                $setpSet[$i - 1]++;
            }
            if($i - 1 == 0 && $setpSet[$i - 1] > $numSet){
                return $newSet;
            }
        }
        $check = [];
        for ($i = ($num - 1); $i >= 0 ; $i--) { 
            $check[$setpSet[$i]] = 0;
        }
        if(count($check) < $num){
            $setpSet[$num - 1]++;
            continue;
        }
        $numArr = [];
        for ($i = 0; $i < $num ; $i++) { 
            $numArr[] = $set[$setpSet[$i]];
        }
            $newSet[] = implode(',', $numArr);
        $setpSet[$num - 1]++;
    }
}
