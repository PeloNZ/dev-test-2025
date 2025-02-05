<?php
// Develop a function that accepts an array of integers and calculates the sum of all the even values in the array.

/**
 * @param int[] $numbers
 * @return int
 */
function sumEvenIntegers(array $numbers): int
{
    // simple filter array for even values then sum. Could probably use array_reduce here to do it in one step.
    // total time spent ~10 mins.
    return array_sum(array_filter($numbers, fn($n) => !($n & 1)));
}

$test1 = [-1,-6,0,1,2,3,4,100,55, 67, 66];

echo "sum even integers, go!\r\n";

echo sumEvenIntegers($test1);
