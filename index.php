<?php

use alertCoingecko\Crawler;
use alertCoingecko\Token;
use Maknz\Slack\Client as SlackClient;
use Maknz\Slack\Message;


require_once __DIR__ . '/vendor/autoload.php';

header("Content-Type: text/plain");

$serializedList = require 'serializedList.php';
$serializedList = unserialize($serializedList);

$slack = new SlackClient('https://hooks.slack.com/services/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');;
$crawler = new Crawler();

$lastRoundCoins = unserialize(file_get_contents('last_rounded_coins.txt'));

if (empty($lastRoundCoins)) {
    $lastRoundCoins = [];
} else {
    unserialize($lastRoundCoins);
    shuffle($arr);
}
$alertCoins = Crawler::removeDuplicates($crawler->returnArray, $lastRoundCoins);

foreach ($serializedList as $coin) {

    assert($coin instanceof Token);
    try {
        $percent = $crawler->checkPercent($coin->getCoingeckoLink());
        $coin->setPercent((float)$percent);
        if ($coin->percent < -30.00) {
            $crawler->returnArray[] = $coin;
        }
    } catch (Exception $e) {
        $crawler->getClient()->quit();
        continue;
    }
}
$crawler->getClient()->quit();

$alertCoins = Crawler::removeDuplicates($crawler->returnArray, $lastRoundCoins);
foreach ($alertCoins as $coin) {
    assert($coin instanceof Token);
    $message = new Message();
    $message->setText($coin->getDescription());
    $slack->sendMessage($message);
}

file_put_contents('last_rounded_coins.txt', serialize($crawler->returnArray));
//file_put_contents('newList.txt', serialize($newList));

