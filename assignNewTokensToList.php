<?php

use alertCoingecko\Crawler;
use alertCoingecko\Token;
use Maknz\Slack\Client as SlackClient;
use Maknz\Slack\Message;


require_once __DIR__ . '/vendor/autoload.php';

header("Content-Type: text/plain");
$list = file_get_contents('list.txt');
$list = explode("\n", $list);

//$arr = array_unique($list);
//$arr = file_put_contents('list.txt', serialize($arr));
//die;

$crawler = new Crawler();

//$lastRoundCoins = unserialize(file_get_contents('last_rounded_coins.txt'));

//if (empty($lastRoundCoins)) {
//    $lastRoundCoins = [];
//}

//$alertCoins = Crawler::removeDuplicates($crawler->returnArray, $lastRoundCoins);

//shuffle($list);
$newList = [];
foreach ($list as $coin) {

    try {

        $data = $crawler->assignDetailInformationToCoin(trim($coin));
        if ($data[0] != null && $data[2] != null && $data[1] != null) {
            $token = new Token($data[0], $data[2], $data[1], trim($coin));
            $newList[] = $token;
            echo $token->getName() . PHP_EOL;
        }

    } catch (Exception $e) {
        continue;
    }
}
$crawler->getClient()->quit();

file_put_contents('newList.txt', serialize($newList));

