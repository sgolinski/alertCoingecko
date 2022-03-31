<?php

namespace alertCoingecko;


use Symfony\Component\Panther\Client as PantherClient;

class Crawler
{
    public PantherClient $client;

    public array $returnArray;


    public function __construct()
    {
        $this->client = PantherClient::createChromeClient();
        $this->returnArray = [];
    }


    public function assignDetailInformationToCoin($link)
    {

        $this->client->get(trim($link));
        $this->client->refreshCrawler();

//        return $this->client->getCrawler()
//            ->filter('div.coin-link-row.tw-mb-0 > div > div > img ')
//            ->getAttribute('data-address');

        return $this->client->getCrawler()
            ->filter('span.live-percent-change.tw-ml-2.tw-text-xl')
            ->getText();


    }


    public
    static function removeDuplicates($arr1, $arr2)
    {
        $uniqueArray = [];
        $notUnique = false;
        if (!empty($arr2)) {
            foreach ($arr1 as $coin) {
                $notUnique = false;
                foreach ($arr2 as $coin2) {
                    if (trim($coin) == trim($coin2)) {
                        $notUnique = true;
                    }
                }
                if (!$notUnique) {
                    $uniqueArray[] = trim($coin);
                }
            }
            return $uniqueArray;
        } else {
            return $arr1;
        }
    }

    public function getClient()
    {
        return $this->client;
    }

}