<?php

namespace alertCoingecko;

class Token
{
    public string $name = '';
    public string $price = '';
    public float $percent = 0.0;
    public string $mainet = '';
    public string $address = ' ';
    public string $poocoinLink = '';
    public string $coingeckoLink = '';
    public string $bscLink = '';

    public function getBscLink(): string
    {
        return $this->bscLink;
    }

    public function setBscLink(string $bscLink): void
    {
        $this->bscLink = $bscLink;
    }

    public function __construct($name, $percent, $address, $link)
    {
        $this->name = $name;
        $this->percent = (float)$percent;
        $this->coingeckoLink = trim($link);
        $this->address = $address;
        $this->setPoocoinLink('https://poocoin.app/tokens/' . $address);
        $this->setBscLink('https://bscscan.com/token/' . $address);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }
    
    public function setAddress(string $address): void
    {
        $this->address = $address;
        $this->setPoocoinLink('https://poocoin.app/tokens/' . $address);
        $this->setBscLink('https://bscscan.com/token/' . $address);
    }

    public function getPoocoinLink(): string
    {
        return $this->poocoinLink;
    }

    public function setPoocoinLink(string $poocoinLink): void
    {
        $this->poocoinLink = $poocoinLink;
    }

    public function getCoingeckoLink(): string
    {
        return $this->coingeckoLink;
    }

    public function getDescription(): ?string
    {

        return "Name: " . $this->getName() . PHP_EOL .
            "Drop percent: " . $this->getPercent() . "%" . PHP_EOL .
            "Coingecko: " . $this->getCoingeckoLink() . PHP_EOL .
            "Poocoin:  " . $this->getPoocoinLink() . PHP_EOL;

    }

    public function setPercent(float $percent)
    {
        $this->percent = $percent;
    }
}
