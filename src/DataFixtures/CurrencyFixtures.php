<?php

namespace App\DataFixtures;

use App\Entity\Currencies;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    public const CURRENCIES = ['USD',
        'AUD',
        'BRL',
        'CAD',
        'CHF',
        'CLP',
        'CNY',
        'DKK',
        'EUR',
        'GBP',
        'HKD',
        'INR',
        'ISK',
        'JPY',
        'KRW',
        'NZD',
        'PLN',
        'RUB',
        'SEK',
        'SGD',
        'THB',
        'TRY',
        'TWD'];

    public function load(ObjectManager $manager)
    {
        foreach (self::CURRENCIES as $item) {
            $currency = new Currencies();
            $currency->setCode($item);
            $manager->persist($currency);
        }

        $manager->flush();
    }
}
