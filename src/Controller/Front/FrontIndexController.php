<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontIndexController extends AbstractController
{
    #[Route('/', name: 'app_front_index')]
    public function index(): Response
    {
        return $this->render('front_index/index.html.twig', [
            'controller_name' => 'FrontIndexController',
        ]);
    }
}
