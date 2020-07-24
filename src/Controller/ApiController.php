<?php


namespace App\Controller;

use App\Entity\Currencies;
use App\Entity\Rates;
use App\Helper\ParamsHelper;
use DateTime;
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

    protected $helper;

    public function __construct(ParamsHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @Rest\Get("/params", name="params")
     * @return JsonResponse
     */
    public function getParams(): JsonResponse
    {
        return $this->json([
            array_keys($this->helper->getDateRange()),
            $this->helper->currenciesGet()
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
        $labels = $this->helper->createDates($range);
        $data = array_map(function ($date) use ($currency_id) {
            $rate = $this->ratesQuery($currency_id, $date);
            return !empty($rate) ? $rate->getRateValue() : 0;
        }, $labels);

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


}