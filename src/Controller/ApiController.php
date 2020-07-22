<?php


namespace App\Controller;

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
     * @Rest\Get("/params", name="params")
     * @return JsonResponse
     */
    public function getParams(): JsonResponse
    {
        return $this->json([
            ['12h', '24h', '3d', '7d', '15d', '30d', '3m', '6m', '1y'],
            ["USD", "EUR", "RUB",]
        ]);
    }

    /**
     * @Rest\Get("/rate", name="rate" )
     * @param Request $request
     * @return JsonResponse
     */
    public function getRate(Request $request): JsonResponse
    {
        $range = $request->get('range');
        $currency = $request->get('currency');
        $labels = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        shuffle($labels);
        $data = array_map(function () {
            return random_int(-20, 20);
        }, $labels);
        shuffle($data);

        return $this->json([
            'labels'=>$labels,
            'datasets' =>
            [
                [
                    'label' => 'BTC/' . $currency,
                    'data' => $data
                ],
                [
                    'label' => 'BTC/' . $currency,
                    'data' => $data
                ]
            ]
        ]);
    }

}