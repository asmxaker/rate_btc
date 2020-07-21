<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="mainpage")
     */
    public function index()
    {
        $number = 1;

        return $this->render('base.html.twig', ['number' => $number]);
    }
}