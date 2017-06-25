<?php

/**
 * 冒泡排序
 * @param array $arr
 * @return  array
 */
function bubbleSort(array $arr)
{
    $total = count($arr);
    for ($i = 0; $i < $total - 1; $i++) {
        for ($j = 0; $j < $total - $i - 1; $j++) {
            if ($arr[$j + 1] < $arr[$j]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}

/**
 * 选择排序
 * @param array $arr
 * @return  array
 */
function selectSort(array $arr)
{
    $total = count($arr);
    for ($i = 0; $i < $total - 1; $i++) {
        $min = $i;
        //找出最小值
        for ($j = $i + 1; $j < $total; $j++) {
            if ($arr[$j] < $arr[$min]) {
                $min = $j;
            }
        }
        //放到已排列的末尾
        if ($min != $i) {
            $temp = $arr[$min];
            $arr[$min] = $arr[$i];
            $arr[$i] = $temp;
        }
    }
    return $arr;
}

/**
 * 插入排序
 * @param array $arr
 * @return  array
 */
function insertSort(array $arr)
{
    $total = count($arr);
    for ($i = 1; $i < $total; $i++) {
        $temp = $arr[$i];
        //已排序的最大索引
        $j = $i - 1;
        //从高位开始比较，如果比$temp大，右移，直到找到比$temp小的位置
        while ($j >= 0 && $arr[$j] > $temp) {
            $arr[$j + 1] = $arr[$j];
            $j--;
        }
        //放到合适位置
        $arr[$j + 1] = $temp;
    }
    return $arr;
}

/**
 * 希尔排序
 * @param array $arr
 * @return  array
 */
function shellSort(array $arr)
{
    $total = count($arr);
    $step = 2;
    for ($gap = floor($total / $step); $gap > 0; $gap = floor($gap / $step)) {
        for ($i = $gap; $i < $total; $i++) {
            for ($j = $i - $gap; $j >= 0 && $arr[$j + $gap] < $arr[$j]; $j -= $gap) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + $gap];
                $arr[$j + $gap] = $temp;
            }
        }
    }
    return $arr;
}

/**
 * 合并两个有序数组
 * @param $arr1
 * @param $arr2
 * @return array
 */
function sortedMergeArray($arr1, $arr2)
{
    $arr = array();
    while (count($arr1) && count($arr2)) {
        $arr[] = $arr1['0'] < $arr2['0'] ? array_shift($arr1) : array_shift($arr2);
    }
    return array_merge($arr, $arr1, $arr2);
}

/**
 * 归并排序
 * @param array $arr
 * @return array
 */
function mergeSort(array $arr)
{
    //递归结束条件,到达这步的时候,数组就只剩下一个元素了,也就是分离了数组
    $total = count($arr);
    if ($total <= 1) {
        return $arr;
    }
    //取数组中间
    $mid = intval($total / 2);
    //左边部分
    $left_arr = array_slice($arr, 0, $mid);
    //右边部分
    $right_arr = array_slice($arr, $mid);
    //递归左边归并排序
    $left_arr = mergeSort($left_arr);
    //递归右边归并排序
    $right_arr = mergeSort($right_arr);

    //合并
    $arr = sortedMergeArray($left_arr, $right_arr);

    return $arr;
}


/**
 * 快速排序
 * @param $arr
 * @return array
 */
function quickSort($arr)
{
    $size = count($arr);
    if ($size <= 1) {
        return $arr;
    }

    //基准值
    $first = $arr[0];
    //小于$first的数组
    $left = array();
    //大于等于$first的数组
    $right = array();

    //基于首元素$first进行分组
    for ($i = 1; $i < $size; $i++) {
        if ($arr[$i] <= $first) {
            $left[] = $arr[$i];
        } elseif ($arr[$i] > $first) {
            $right[] = $arr[$i];
        }
    }
    $left = quickSort($left);
    $right = quickSort($right);

    return array_merge($left, array($first), $right);
}

/**
 * 基数排序 LSD
 * @param array $arr
 */
function radixSort(array &$arr)
{
    //最大数
    $max = max($arr);
    //最大位数
    $len = strlen($max);
    //基数依次排序
    for ($i = 1; $i <= $len; $i++) {
        radixMain($arr, $i);
    }
}

function radixMain(array &$arr, $loop)
{
    //个百位 依次为 1 10 100……
    $pos = pow(10, $loop - 1);

    $count = count($arr);
    //初始化桶
    $temp = array_fill(0, $count, 0);
    //根据 $loop位 放入桶中
    for ($i = 0; $i < $count; $i++) {
        $index = intval(($arr[$i] / $pos) % 10);

        if (is_array($temp[$index])) {
            $temp[$index][] = $arr[$i];
        } else {
            $temp[$index] = [$arr[$i]];
        }
    }
    //按在桶中顺序取出
    $k = 0;
    foreach ($temp as $values) {
        if ($values == 0) continue;
        foreach ($values as $v) {
            $arr[$k++] = $v;
        }
    }
    unset($temp);
}


/**
 * 堆排序
 * @param array $arr
 */
function heapSort(array &$arr)
{
    $count = count($arr);

    for ($i = floor($count / 2) - 1; $i >= 0; $i--) {
        headAdjust($arr, $i, $count);
    }

    for ($i = $count - 1; $i >= 0; $i--) {
        $temp = $arr[0];
        $arr[0] = $arr[$i];
        $arr[$i] = $temp;
        headAdjust($arr, 0, $i);
    }
}

function headAdjust(array &$arr, $i, $count)
{
    for (; 2 * $i + 1 < $count; $i = $child) {
        $child = 2 * $i + 1;

        if ($child < $count - 1 && $arr[$child + 1] > $arr[$child]) {
            $child++;
        }

        if ($arr[$i] < $arr[$child]) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$child];
            $arr[$child] = $temp;
        } else {
            break;
        }
    }
}
