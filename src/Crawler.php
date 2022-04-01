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


        $name = $this->client->getCrawler()
            ->filter('div.tw-flex.tw-text-gray-900')
            ->getText();


        $address = $this->client->getCrawler()
            ->filter('div.coin-link-row.tw-mb-0 > div > div > img ')
            ->getAttribute('data-address');

        $percent = $this->client->getCrawler()
            ->filter('span.live-percent-change.tw-ml-2.tw-text-xl')
            ->getText();

        return [$name, $address, $percent];
    }

    public function checkPercent($link)
    {
        $this->client->get(trim($link));
        $this->client->refreshCrawler();

        return  $this->client->getCrawler()
            ->filter('div.tw-flex-1.py-2.border.px-0.tw-rounded-md.tw-rounded-t-none.tw-rounded-r-none')
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
                assert($coin instanceof Token);
                foreach ($arr2 as $coin2) {
                    assert($coin2 instanceof Token);
                    if (trim($coin->getName()) == trim($coin2->getName())) {
                        $notUnique = true;
                    }
                }
                if (!$notUnique) {
                    $uniqueArray[] = $coin;
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