<?php

use alertCoingecko\Crawler;
use alertCoingecko\Token;
use Maknz\Slack\Client as SlackClient;
use Maknz\Slack\Message;

require_once __DIR__ . '/vendor/autoload.php';
header("Content-Type: text/plain");

$serializedList = require 'serializedList0_450.php';
$serializedList = unserialize($serializedList);

$slack = new SlackClient('https://hooks.slack.com/services/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');;
$crawler = new Crawler();
$lastRoundCoins = null;

try {
    $lastRoundCoins = file_get_contents('last_rounded_coins.txt');
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
if (empty($lastRoundCoins)) {
    $lastRoundCoins = [];
} else {
    $lastRoundCoins = unserialize($lastRoundCoins);
    shuffle($serializedList);
}

foreach ($serializedList as $coin) {
    assert($coin instanceof Token);
    if (!array_search($coin->getName(), $lastRoundCoins)) {
        try {
            $percent = $crawler->checkPercent($coin->getCoingeckoLink());
            $coin->setPercent((float)$percent);
            if ($coin->percent < -30.00) {
                $message = new Message();
                $message->setText($coin->getDescription());
                $slack->sendMessage($message);
                $crawler->returnArray[] = $coin;
            }
        } catch (Exception $e) {
            $crawler->getClient()->quit();
            continue;
        }
    }

}
$crawler->getClient()->quit();

if (count($crawler->returnArray) > 0) {
    file_put_contents('last_rounded_coins.txt', serialize($crawler->returnArray));
}
sleep(30);