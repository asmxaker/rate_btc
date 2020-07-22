<?php


namespace App\Command;

use App\Entity\Currencies;
use App\Entity\Rates;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GetRateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:get-rate';

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
        parent::__construct();
        $this->container = $container;
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('')
            ->setHelp('');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $result = $this->getJsonRates();
        } catch (GuzzleException $e) {
            return $e->getCode();
        }
        foreach ($result as $key => $item) {
            $output->writeln($key);
            $output->writeln($item->last);
            $entityManager = $this->container->get('doctrine')->getManager();
            $rate = new Rates();
            $rate->setCurrencyId($this->getCurrency($key));
            $rate->setRateValue($item->last);
            $entityManager->persist($rate);
            $entityManager->flush();
        }

        $output->writeln('');
        return 0;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getJsonRates()
    {
        $guzzle = new Client(['base_uri' => 'https://blockchain.info/']);
        $result = $guzzle->request('GET', 'ticker')->getBody()->getContents();
        return json_decode($result);
    }

    /**
     * @param $code
     * @return Currencies
     */
    protected function getCurrency($code)
    {
        $repository = $this->container->get('doctrine')->getRepository(Currencies::class);
        $currency = $repository->findOneBy(['code' => $code]);
        if (!$currency) {
            $entityManager = $this->container->get('doctrine')->getManager();
            $currency = new Currencies();
            $currency->setCode($code);
            $entityManager->persist($currency);
            $entityManager->flush();
        }
        return $currency;
    }


}