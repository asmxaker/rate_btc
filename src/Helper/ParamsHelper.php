<?php


namespace App\Helper;


use App\Entity\Currencies;
use App\Repository\CurrenciesRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class ParamsHelper
 * @package App\Helper
 */
class ParamsHelper
{
    /**
     * date range for period
     */
    protected const DATE_RANGE = [
        '12 hours' => 'PT1H', '24 hours' => 'PT1H', '3 days' => 'PT4H', '7 days' => 'PT8H', '15 days' => 'PT12H', '30 days' => 'P2D', '3 months' => 'P7D', '6 months' => 'P15D', '1 year' => 'P1M'
    ];

    /**
     * @var CurrenciesRepository
     */
    private $currenciesRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->currenciesRepository = $entityManager->getRepository(Currencies::class);
    }

    /**
     * @return array
     */
    public function currenciesGet(): array
    {
        $currencies = $this->currenciesRepository->findAllArray();
        $collection = new ArrayCollection($currencies);
        $filteredCollection = $collection->map(function ($el) {
            return $el['code'];
        });

        return $filteredCollection->toArray();
    }


    /**
     * @param string $range
     * @param null $interval
     * @return array
     * @throws \Exception
     */
    public static function createDates(string $range, $interval = null): array
    {
        $start = new DateTime('-' . $range);
        $interval = new DateInterval($interval ?? self::intervalGet($range));
        $end = new DateTime(NULL);
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $date) {
            $dateArray[] = $date->format('Y-m-d H:00');
        }

        return $dateArray ?? [];
    }


    /**
     * @param string $val
     * @return string
     */
    public static function intervalGet(string $val): string
    {
        return self::DATE_RANGE[$val] ?? 'PT1H';
    }

    /**
     * @param string $val
     * @return string[]
     */
    public static function getDateRange(): array
    {
        return self::DATE_RANGE;
    }

}