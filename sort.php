<?php

$arr = [2, 8, 4, 5, 7, 8, 9, 1, 2, 4];

/**
 * 冒泡排序
 * @param array $arr
 * @return array
 */
function bubbleSort(array $arr)
{
    $count = count($arr);
    for ($i = 0; $i < $count; $i++) {
        for ($j = 0; $j < $count - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}




