<?php

use alertCoingecko\Token;

$list = file_get_contents('newList_802-1202.txt');
$list = unserialize($list);
foreach ($list as $link) {

    file_put_contents('fixedList.txt', $link->getCoingeckoLink() . PHP_EOL, FILE_APPEND);
}