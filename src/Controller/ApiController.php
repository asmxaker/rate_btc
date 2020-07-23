<?php


namespace App\Controller;

use App\Entity\Currencies;
use App\Entity\Rates;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 * @package App\Controller
 * @Rest\Route("/api",  name="api_", methods={"GET|POST"})
 */
class ApiController extends AbstractFOSRestController
{

    /**
     * date range for period
     */
    protected const DATE_RANGE = [
        '12 hours' => 'PT1H', '24 hours' => 'PT1H', '3 days' => 'PT4H', '7 days' => 'PT8H', '15 days' => 'PT12H', '30 days' => 'P2D', '3 months' => 'P7D', '6 months' => 'P15D', '1 year' => 'P1M'
    ];


    /**
     * @Rest\Get("/params", name="params")
     * @return JsonResponse
     */
    public function getParams(): JsonResponse
    {
       $currencies = $this->currenciesGet();

        return $this->json([
            array_keys(self::DATE_RANGE),
            $currencies
        ]);
    }

    /**
     * @Rest\Get("/rate", name="rate" )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getRate(Request $request): JsonResponse
    {
        $range = $request->get('range');
        $currency = $request->get('currency', 'USD');
        $currency_id = $this->getDoctrine()->getRepository(Currencies::class)->findOneBy(['code' => $currency]);
        $labels = self::createDates($range);
        $data = array_map(function ($date) use ($currency_id) {
            $rate = $this->ratesQuery($currency_id, $date);
            return !empty($rate) ? $rate->getRateValue() : 0;
        }, $labels);
        shuffle($data);

        return $this->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'BTC/' . $currency,
                    'fill' => false,
                    'borderColor' => '#f00',
                    'data' => $data
                ]
            ]
        ]);
    }

    /**
     * @param $currency
     * @param $date
     * @return object|null
     * @throws \Exception
     */
    public function ratesQuery($currency, $date)
    {
        return $this->getDoctrine()
            ->getRepository(Rates::class)
            ->findOneBy(['currency' => $currency, 'created_at' => new DateTime($date)]);
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
     * @return array
     */
    public function currenciesGet(): array
    {
        $currencies = $this->getDoctrine()->getRepository(Currencies::class)->findAllArray();
        $collection = new ArrayCollection($currencies);
        $filteredCollection = $collection->map(function ($el) {
            return $el['code'];
        });

        return $filteredCollection->toArray();
    }


}