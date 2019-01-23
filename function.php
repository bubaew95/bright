<?php

function dump($str){
    echo "<pre>";
    print_r($str);
    echo "</pre>";
}

function newSubstr($text, $start, $end)
{
    $str = mb_substr($text, $start, $end, 'UTF-8');
    if(strlen($text) > $end)
        return $str . "...";
    return $str;
}
