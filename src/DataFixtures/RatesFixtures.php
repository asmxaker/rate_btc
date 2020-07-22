<?php

namespace App\DataFixtures;

use App\Controller\ApiController;
use App\Entity\Currencies;
use App\Entity\Rates;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class RatesFixtures extends Fixture
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * GetRateCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        foreach (ApiController::createDates('1 year', 'PT1H') as $date){
            foreach (CurrencyFixtures::CURRENCIES as $key=>$value){
                $repository = $this->container->get('doctrine')->getRepository(Currencies::class);
                $currency = $repository->findOneBy(['code' => $value]);
                $rate = new Rates();
                $rate->setRateValue(random_int(4000,20000));
                $rate->created_at = new \DateTime($date);
                $rate->setCurrencyId($currency);
                $manager->persist($rate);
            }
        }
        $manager->flush();
    }
}
