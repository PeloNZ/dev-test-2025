<?php
// A number is a palindrome if it reads the same forwards and backwards, like 101, 555, or
// 20102. Write a function that checks if a given string has this property

function isPalindrome(string $mystery): bool
{
    // works for alphanum strings
    // time spent ~10 mins
    return $mystery === strrev($mystery);
}

echo "is $argv[1] a palindromic number?\r\n";

echo isPalindrome($argv[1]) ? " yes :) " : " no :( ";
