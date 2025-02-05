<?php

// Build a function that identifies the second-highest value in a list of integers

function getPenultimateMaxValue(array $numbers): int
{
    // sort highest to lowest then just pop the 1st index value
    rsort($numbers, SORT_NUMERIC);

    return $numbers[1];
}

$test1 = [0,1,2,3,4,5,77,-2,654,1,-500];

echo "the second highest value in the list of integers is: " . getPenultimateMaxValue($test1) . "\r\n";
